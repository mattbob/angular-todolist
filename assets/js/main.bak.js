var todoApp = angular.module('todoApp', ['LocalStorageModule']);

todoApp.controller('TodoCtrl', ['$scope', 'localStorageService', function ($scope, localStorageService) {
	$scope.todos = [];
	var savedTodos = localStorageService.get('todos');
	if(savedTodos) $scope.todos = savedTodos;

	$scope.addTodo = function() {
		$scope.todos.push({text:$scope.todoText, done:false, project:$scope.todoProject});
		localStorageService.set('todos', $scope.todos);
		$scope.todoText = '';
	};

	$scope.remaining = function() {
		var count = 0;
		angular.forEach($scope.todos, function(todo) {
			count += todo.done ? 0 : 1;
		});
		return count;
	};

	$scope.archive = function() {
		// Grab current todo list
		var oldTodos = $scope.todos;

		// Empty todo list
		$scope.todos = [];
		localStorageService.set('todos', $scope.todos);

		// If task is not done add back to list
		angular.forEach(oldTodos, function(todo) {
			if (!todo.done) $scope.todos.push(todo);
		});
		localStorageService.set('todos', $scope.todos);
	};
}]);