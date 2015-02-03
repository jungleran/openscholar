<?php

/**
 * @file
 * Contains \RestfulQueryVariable
 */

class OsRestfulRoles extends \OsRestfulDataProvider {

  protected $validateHandler = 'roles';

  /**
   * {@inheritdoc}
   */
  public static function controllersInfo() {
    return array(
      '' => array(
        \RestfulInterface::GET => 'index',
        \RestfulInterface::HEAD => 'index',
        \RestfulInterface::POST => 'create',
        \RestfulInterface::DELETE => 'remove',
      ),
      // We don't know what the ID looks like, assume that everything is the ID.
      '^.*$' => array(
        \RestfulInterface::GET => 'view',
        \RestfulInterface::HEAD => 'view',
        \RestfulInterface::PUT => 'replace',
        \RestfulInterface::PATCH => 'update',
        \RestfulInterface::DELETE => 'remove',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function publicFieldsInfo() {
    return array(
      'rid' => array(
        'property' => 'rid',
      ),
      'name' => array(
        'property' => 'name',
      ),
      'gid' => array(
        'property' => 'gid',
      ),
      'group_bundle' => array(
        'property' => 'group_bundle',
      ),
      'group_type' => array(
        'property' => 'group_type',
      ),
    );
  }

  /**
   * Overrides RestfulDataProviderDbQuery::queryForListFilter().
   *
   * Display the group roles by the group ID.
   *
   * {@inheritdoc}
   */
  protected function queryForListFilter(\SelectQuery $query) {
    parent::queryForListFilter($query);

    $request = $this->getRequest();

    if (empty($request['vsite'])) {
      throw new \RestfulForbiddenException('You must specify a vsite ID.');
    }

    $wrapper = entity_metadata_wrapper('node', $request['vsite']);

    if ($wrapper->og_roles_permissions->value()) {
      $query->condition('gid', $request['vsite']);
    }
    else {
      $query->condition('group_bundle', $wrapper->getBundle());
      $query->condition('gid', 0);
    }
  }

  /**
   * Overrides RestfulDataProviderDbQuery::create().
   *
   * Verify the uer have permission to invoke this method.
   */
  public function create() {
    $this->validate();
    return parent::create();
  }

  /**
   * Overrides RestfulDataProviderDbQuery::update().
   *
   * Verify the uer have permission to invoke this method.
   */
  public function update($id, $full_replace = FALSE) {
    $this->validate();
    return parent::update($id, $full_replace);
  }

  /**
   * Overrides RestfulDataProviderDbQuery::delete().
   *
   * Verify the uer have permission to invoke this method.
   */
  public function delete($path = '', array $request = array()) {
    $this->validate(FALSE);
    return parent::delete();
  }

  /**
   * Overrides
   */
  public function validate($validate_request = TRUE) {
    $this->getObject();
    $this->object->group_type = 'node';

    if (empty($this->object->gid)) {
      $this->object->gid = 0;
    }

    $this->object->gid = (int) $this->object->gid;

    $this->setRequest((array) $this->object);

    if ($validate_request) {
      parent::validate();
    }

    $function = $this->object->gid ? 'og_user_access' : 'user_access';
    $params = $this->object->gid ? array('node', $this->object->gid, 'administer users', $this->getAccount()) : array('administer users', $this->getAccount());

    if (!call_user_func_array($function, $params)) {
      throw new \RestfulForbiddenException('You are not allowed to manage roles.');
    }
  }
}
