<!doctype html>
<html ng-app="todoApp">
<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style type="text/css">
	.done-true{
	text-decoration:line-through;
	color:grey;
	}
    </style>
</head>

<body>

	<h2>Todo</h2>
	<div ng-controller="TodoCtrl">
		<span>{{remaining()}} of {{todos.length}} remaining tasks </span> [ <a href="" ng-click="archive()">Clear Completed</a> ]

		<select ng-model="projects" ng-options="todo.project for todo in todos">
		</select>

		<ul class="tasks">
			<li ng-repeat="todo in todos | filter:projects">
				<input type="checkbox" ng-model="todo.done">
				<span class="done-{{todo.done}}">{{todo.text}}</span>
			</li>
		</ul><!-- .tasks -->

		<form ng-submit="addTodo()">
			<input type="text" ng-model="todoText" size="30" placeholder="add new todo here">
			<input type="text" ng-model="todoProject" size="30" placeholder="assign task to a project">
			<input class="btn-primary" type="submit" value="add">
		</form>
	</div><!-- TodoCtrl -->

	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.0-beta.13/angular.min.js"></script>
	<script src="assets/js/plugins/angular-local-storage.min.js"></script>
	<script src="assets/js/main.bak.js"></script>

</body>

</html>