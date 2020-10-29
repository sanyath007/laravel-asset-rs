/**
  AngularJS
*/

var env = {};

// Import variables if present (from env.js)
if(window){  
  Object.assign(env, window.__env);
}

var app = angular.module('app', ['xeditable','ngTagsInput','toaster','ngAnimate','angularModalService']);

app.constant('CONFIG', env);

// app.factory('_', ['window', function () {
//     return window._;
// }]);

app.run(function(editableOptions) {
    editableOptions.theme = 'bs3'; // bootstrap3 theme. Can be also 'bs2', 'default'
    editableOptions.activate = 'select';
});

app.controller('ModalController', function($scope, close){
	// close('Success!');
});

app.filter('thdate', function($filter)
{
 	return function(input)
 	{
  		if(input == null){ return ""; } 

  		var arrDate = input.split('-');
  		var thdate = arrDate[2]+ '/' +arrDate[1]+ '/' +(parseInt(arrDate[0])+543);
 
  		return thdate;
 	};
});
