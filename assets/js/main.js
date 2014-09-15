/* TABLE OF CONTENTS ---------

- VARIABLES
- PROJECT FUNCTIONS
- TASK FUNCTIONS

/* TO DOS --------------------

- Delete projects
- Edit tasks
- Edit projects
- Add task due date

------------------------------ */


var todoApp = angular.module('todoApp', ['LocalStorageModule']);

todoApp.controller('TodoCtrl', ['$scope', '$filter', 'localStorageService', function ($scope, $filter, localStorageService) {

	// VARIABLES

	$scope.projects = [];
	var savedProjects = localStorageService.get('projects');
	if(savedProjects) $scope.projects = savedProjects;

	$scope.tasks = [];
	var savedTasks = localStorageService.get('tasks');
	if(savedTasks) $scope.tasks = savedTasks;

	$scope.completedTasks = [];
	var savedCompletedTasks = localStorageService.get('completedTasks');
	if(savedCompletedTasks) $scope.completedTasks = savedCompletedTasks;

	$scope.archivedTasks = [];
	var savedArchivedTasks = localStorageService.get('archivedTasks');
	if(savedArchivedTasks) $scope.archivedTasks = savedArchivedTasks;


	// PROJECT FUNCTIONS

	$scope.addProject = function() {
		$scope.projects.push({name: $scope.projectName});
		localStorageService.set('projects', $scope.projects);
		$scope.projectName = '';
	};

	$scope.tasksRemaining = function(selectedProject) {
		$scope.selected = selectedProject;

		var count = 0;
		var tasks = localStorageService.get('tasks');

		angular.forEach(tasks, function(task) {
			if (task.project.name === selectedProject.name) {
				count++;
			}
		});

		if (count !== 0) {
			return count;
		}
	};

	$scope.projectFilter = function(project) {
		if($scope.projectFilterName === project) {
			$scope.projectFilterName = '';
		} else {
			$scope.projectFilterName = project;
		}
	};


	// TASK FUNCTIONS

	$scope.addTask = function() {
		$scope.tasks.push({name: $scope.taskName, project: $scope.taskProject, date: Date.now(), done: false});
		localStorageService.set('tasks', $scope.tasks);
		$scope.taskName = '';
	};

	$scope.sortTasks = function(predicate, reverse) {
		var orderBy = $filter('orderBy');
		$scope.tasks = orderBy($scope.tasks, predicate, reverse);
    };

	$scope.sortCompletedTasks = function(predicate, reverse) {
		var orderBy = $filter('orderBy');
		$scope.completedTasks = orderBy($scope.completedTasks, predicate, reverse);
    };

	$scope.completeTask = function(selectedTask) {
		$scope.selected = selectedTask;

		var index = $scope.tasks.indexOf( selectedTask );

		$scope.completedTasks.push(selectedTask);
		$scope.tasks.splice(index, 1);
		selectedTask = null;

		localStorageService.set('tasks', $scope.tasks);
		localStorageService.set('completedTasks', $scope.completedTasks);
	};

	$scope.uncompleteTask = function(selectedTask) {
		$scope.selected = selectedTask;

		var index = $scope.completedTasks.indexOf( selectedTask );

		$scope.tasks.push(selectedTask);
		$scope.completedTasks.splice(index, 1);
		selectedTask = null;

		localStorageService.set('tasks', $scope.tasks);
		localStorageService.set('completedTasks', $scope.completedTasks);
	};

	$scope.deleteTask = function(selectedTask) {
		$scope.selected = selectedTask;

		var index = $scope.tasks.indexOf( selectedTask );

		$scope.tasks.splice(index, 1);
		selectedTask = null;

		localStorageService.set('tasks', $scope.tasks);
	};

	$scope.deleteCompletedTask = function(selectedTask) {
		$scope.selected = selectedTask;

		var index = $scope.completedTasks.indexOf( selectedTask );

		$scope.completedTasks.splice(index, 1);
		selectedTask = null;

		localStorageService.set('completedTasks', $scope.completedTasks);
	};

	$scope.console = function(log) {
		console.log(log);
	};

	// Task Sorting
    var startIndex = -1;
	$('.tasks-remaining .table').sortable({
		items: 'tr',
		start: function(event, ui) {
			startIndex = ($(ui.item).index());
		},
		stop: function(event, ui) {
			var newIndex = ($(ui.item).index());
			var toMove = $scope.tasks[startIndex];

			$scope.tasks.splice(startIndex, 1);
			$scope.tasks.splice(newIndex, 0, toMove);

			localStorageService.set('tasks', $scope.tasks);
		}
	});
}]);


$(document).ready(function(){
	$('.navbar-form input[type=text]').on('focus', function() {
		$('.search-clear').fadeIn(250);
	});

	$('.btn-newtask, .tasks form input[type=submit], .task-clear').on('click', function(e) {
		if( $('.tasks .well').hasClass('flipInX') ) {
			$('.tasks-toolbar').delay(250).animate({'margin-top' : 0}, 150);
			$('.tasks .well').removeClass('flipInX').addClass('flipOutX');
		} else {
			$('.tasks-toolbar').animate({'margin-top' : 100}, 100);
			$('.tasks .well').css('visibility', 'visible').removeClass('flipOutX').addClass('flipInX');
		}
	});

	$('.btn-remaining, .btn-completed').on('click', function(e) {
		$('.tasks-remaining').toggle();
		$('.tasks-completed').toggle();
		$('.btn-remaining, .btn-completed').toggleClass('active');
	});

	$('.projects .nav a').on('click', function(e) {
		e.preventDefault();
		$(this).parent('li').toggleClass('active');
		$('.projects .nav li').not( $(this).parent('li') ).removeClass('active');
	});
});