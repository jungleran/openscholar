(function () {
	var rootPath;
    var restPath;
    var vsite;
    var notify_settings;
    var user_data;
    var paths;

    angular.module('UserPanel', ['AdminPanel'])
    .config(function (){
       
       rootPath = Drupal.settings.paths.adminPanelModuleRoot;
       restPath = Drupal.settings.paths.api;
       
       if(typeof(Drupal.settings.spaces) == 'undefined') {
    	 vsite = false;   
       } else {	   
         vsite = Drupal.settings.spaces.id;
       }
       
       user_data = Drupal.settings.user_panel.user;
       paths = Drupal.settings.paths;
       notify_settings = Drupal.settings.os_notifications;
    }).controller("UserMenuController",['$scope', '$http', function ($scope, $http) {
    
      $scope.user = user_data;
      $scope.vsite = { id: vsite };
      $scope.paths = paths;
      $scope.close_others = function(id){
        jQuery('#rightMenuSlide .menu_modal_open').filter("[data-id='"+id+"']").click();  
      };
     
    }]).controller("UserSitesController",['$scope', '$http', function ($scope, $http) {
        
        var url = paths.api + '/users/' + user_data.uid;
        $http({method: 'get', url: url}).
          then(function(response) {
        	if(typeof(response.data.data[0].og_user_node) == 'undefined') {
        	  $scope.site_data = [];
        	} else {
              $scope.site_data = response.data.data[0].og_user_node;
        	}
          });
          $scope.pageSize = 7;
          $scope.numberOfPages=function(data){
            return Math.ceil(data.length/$scope.pageSize);                
          }
        
      }]).directive('rightMenu', function() {
      return {
       templateUrl: rootPath+'/templates/user_menu.html?vers='+Drupal.settings.version.userPanel,
       controller: 'UserMenuController',
     };
    }).directive('addDestination', function() {
      //Add the destination to a URL
	  return {
	    link: function(scope, element, attrs) {
		  var url = (typeof(attrs.href) == 'undefined') ? attrs.ngHref : attrs.href;
	      element.attr('href', url + ((url.indexOf('?') == -1) ? '?' : '&') + 'destination=' + encodeURIComponent(location.href));
  	    },
	  }
    }).directive('loadMySites', function() {
    	 
        return {
            templateUrl: rootPath+'/templates/user_sites.html?vers='+Drupal.settings.version.userPanel,
            controller: 'UserSitesController',
          };
       
    }).directive('notificationCheck', function() {
      //check for google and hopscotch
      if (typeof google == 'undefined' || typeof hopscotch == 'undefined') {
        return {};
	  }
      
      //Go to feed and check for notifications.
  	  return {
  	    link: function(scope, element, attrs) {
  		  count_element = angular.element('<span class="slate alert" ng-alert=></span>');
  		  // @TODO: Add support for multiple feeds.
	      var feed = new google.feeds.Feed(notify_settings.url);
	      var link = element.find('a')[0];
	      
	      feed.setNumEntries(notify_settings.max);
	      feed.load(function (result) {
	        if (result.error) {
            element.hide();
	          return;
	        }

          var items = [],
            oldItems = [];
	          
	        for (var i = 0; i < result.feed.entries.length; i++) {
	          var num_remaining = (result.feed.entries.length - i);
	          var entry = result.feed.entries[i];
              var item = osTour.notifications_item(entry, num_remaining, count_element, link);
	          if (osTour.notifications_is_new(entry)) {
	            items.push(item);
	          }
              else {
                oldItems.push(item);
              }
	        }

          var tour = {};
	        // If there are new items
	        if (items.length) {
	          // Sets up the DOM elements.
	          element.append(count_element);
	          osTour.notifications_count(count_element, items.length);
	            //$('#os-tour-notifications-menu-link').slideDown('slow');
	          
	          // Sets up the tour object with the loaded feed item steps.
	          tour = {
	            showPrevButton: true,
	            scrollTopMargin: 100,
	            id: "os-tour-notifications",
	            steps: items,
	            onEnd: function() {
	              osTour.notifications_count(-1, count_element);
	              osTour.notifications_read_update();
	            }
	          };
	        }
          else {
            oldItems.reverse();

            tour = {
              showPrevButton: true,
              scrollTopMargin: 100,
              id: "os-tour-notifications",
              steps: oldItems
            };
          }

          element.find('a').bind('click', function(e) {
            e.preventDefault();
            if(hopscotch.getCurrTour()) {
              hopscotch.endTour();
            } else {
              hopscotch.startTour(tour);
              jQuery('.hopscotch-bubble').addClass('os-tour-notifications');
            }
          });
	      });
    	},
    }
    }).directive('rightMenuToggle', function() {
        return {
            link: function(scope, element, attrs) {
        	  element.bind('click', function(e) {
        		  e.preventDefault();
        		  element.siblings('div').each( function () {
        	        if(this.style.display == 'none') {
        	          jQuery(this).fadeIn('fast');
        	          jQuery(this).addClass('open');
        	        } else {
        	          jQuery(this).fadeOut('fast');
        	          jQuery(this).removeClass('open');
        	        }
        	      });
              })  
            },
          }
        });
  
})();
