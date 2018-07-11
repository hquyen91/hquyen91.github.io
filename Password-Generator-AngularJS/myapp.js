var passGenerate = angular.module('passGenerate', ['ui.bootstrap']);
var controllers = {};
controllers.passController = function($scope) {
    $scope.passwordLength = 15;
    $scope.upperGen = true;
    $scope.numbersGen = false;
    $scope.symbolsGen = false;

    $scope.generatePassword = function() {
        var lowerLetters = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
        var upperLetters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        var numbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        var specialCharacters = ['!', '"', '"', '#', '$', '%', '&', '\'', '(', ')', '*', '+', ',', '-', '.', '/', ':', ';', '<', '=', '>', '?', '@', '[', '\\', ']', '^', '_', '`', '{', '|', '}', '~'];
        var outCharacters = lowerLetters;
        if ($scope.upperGen) {
            outCharacters = outCharacters.concat(upperLetters);
        }
        if ($scope.numbersGen) {
            outCharacters = outCharacters.concat(numbers);
        }
        if ($scope.symbolsGen) {
            outCharacters = outCharacters.concat(specialCharacters);
        }
        var passwordArray = [];
        for (var i = 1; i < $scope.passwordLength; i++) {
            passwordArray.push(outCharacters[Math.floor(Math.random() * outCharacters.length)]);
        };
        $scope.passwordInput = passwordArray.join("");
    };

};
passGenerate.controller(controllers);