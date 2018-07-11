// myapp.js
var app = angular.module('sa_strength', [])
.controller('controller', ['$scope',
	function($scope) {
		$scope.user_input = {
			pass: ''
		};
	}
])
.directive('passwordStrength', [
	function() {
		return {
			require: 'ngModel',
			restrict: 'E',
			scope: {
				pass: '=ngModel'
			},
			link: function(scope, elem, attrs, ctrl) {
				scope.$watch('pass', function(input_Value) {

					scope.strength = isSatisfied(input_Value && input_Value.length >= 8) +
						isSatisfied(input_Value && /[A-z]/.test(input_Value)) +
						isSatisfied(input_Value && /(?=.*\W)/.test(input_Value)) +
						isSatisfied(input_Value && /\d/.test(input_Value));
					function isSatisfied(criteria) {
						return criteria ? 1 : 0;
					}
				}, true);
			},
			template: '<div class="progress">' +
				'<div class="progress-bar progress-bar-danger progress-bar-striped active" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: {{strength >= 1 ? 25 : 0}}%"></div>' +
				'<div class="progress-bar progress-bar-warning progress-bar-striped active" style="width: {{strength >= 2 ? 25 : 0}}%"></div>' +
				'<div class="progress-bar progress-bar-info progress-bar-striped active" style="width: {{strength >= 3 ? 25 : 0}}%"></div>' +
				'<div class="progress-bar progress-bar-success progress-bar-striped active" style="width: {{strength >= 4 ? 25 : 0}}%"></div>' +
				'</div>'
		}
	}
])
.directive('patternValidator', [
	function() {
		return {
			require: 'ngModel',
			restrict: 'A',
			link: function(scope, elem, attrs, ctrl) {
				ctrl.$parsers.unshift(function(viewStrength) {
					var patt = new RegExp(attrs.patternValidator);
					var isValid = patt.test(viewStrength);
					ctrl.$setValidity('pass_Check', isValid);
					return viewStrength;

				});
			}
		};
	}
]);