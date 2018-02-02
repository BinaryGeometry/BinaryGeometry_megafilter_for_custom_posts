window.mvpmSystemApiUrl   = mvpm_api_object.ajax_url;
window.mvpmUrlDomainPath  = mvpm_api_object.url_domain_path;
window.mvpmPartialsPath   = mvpm_api_object.partials_path;
window.mvpmImagePath      = mvpm_api_object.image_path;
// window.mvpmImagePath   = '/wp-content/plugins/mvp-mechanic/application/build/images/';
window.mvpmFormPath       = mvpm_api_object.form_path;
window.mvpmSystemSecurity = mvpm_api_object.ajax_nonce;

/* User module*/
window.mvpmUserRedirecturl = mvpm_user_object.mvpm_redirecturl;
window.mvpmUserPasswordreseturl = mvpm_user_object.mvpm_passwordreseturl;
window.mvpmUserRegisterurl = mvpm_user_object.mvpm_registerurl;
window.mvpmUserLoginloadingmessage = mvpm_user_object.mvpm_loginloadingmessage;


var toType = function(obj) {

    return ({}).toString.call(obj).match(/\s([a-zA-Z]+)/)[1].toLowerCase()
}
console.log('SearchApp running on Angular', toType(angular) )

// Declare app level module which depends on filters, and services
var SearchApp = angular.module('SearchApp',
    [
    	'ui.router'
        ,'ngAnimate'
        ,'SystemCtrl'
    ]);

// http://stackoverflow.com/questions/31266566/angular-ui-sref-not-working-with-touch-events
SearchApp.config(['$stateProvider', '$urlRouterProvider',
    function ($stateProvider, $urlRouterProvider ) {

        var template_path = window.mvpmPartialsPath

        // var system = {
        //     name: 'system',  //mandatory
        //     abstract: true,
        //     templateUrl: template_path+ '/system.html',
        //     controller: 'SystemCtrl as system',
        //     resolve: SystemCtrl.resolve
        // };

        var systemListing = {
            name: 'system',  //mandatory
            // name: 'system.listing',  //mandatory
            abstract: true,
            // url: '/',
            parent: 'system',
            controller: 'ListingCtrl as listing',
            resolve: ListingCtrl.resolve,
            templateUrl: mvpmPartialsPath+'/listing/view.html'
        }
        
        var systemListingAll = {
            name: 'system.listing',  //mandatory
            // name: 'system.listing.all',  //mandatory
            url: '/',
            parent: 'system.listing',
            views:{
                'context-display' : {
                    templateUrl: mvpmPartialsPath+'/listing/context-display.html',
                },
                'filters' : {
                    templateUrl: mvpmPartialsPath+'/listing/filters.html',
                },
                'list' : {
                    templateUrl: mvpmPartialsPath+'/listing/list.html',
                },
                'saves' : {
                    templateUrl: mvpmPartialsPath+'/listing/saves.html'
                }
            }
        }
        
        $stateProvider
            // .state(system)
            .state(systemListing)
            .state(systemListingAll)

        $urlRouterProvider.otherwise('/');
    }
]);

// In UI-Router 1.0, states can be registered and deregistered at runtime using StateRegistry.register and StateRegistry.deregister.

// To get access to the StateRegistry, inject it as $stateRegistry, or inject $uiRouter and access it via UIRouter.stateRegistry.

// SearchApp.run(['$rootScope', function($rootScope) {
//     console.log('initroot')
//     $rootScope.$on('$stateChangeStart', function(e, curr, prev) {
//         // if (curr.$$route && curr.$$route.resolve) {
//         // Show a loading message until promises are not resolved
//         // $rootScope.isRouteLoading = true;
//         console.log('on')
//         // }
//     });
//     $rootScope.$on('$stateChangeSuccess', function(e, curr, prev) {
//         // Hide loading message
//         $rootScope.isRouteLoading = false;
//         console.log('routing route loading')
//         console.log('off')
//     });
//     $rootScope.$on('$stateChangeError', function(event, toState, toParams, fromState, fromParams, error){
//         // Hide loading message
//         $rootScope.isRouteLoading = false;

//     })
// }]);