<!doctype html>
<html lang="en" data-ng-app="todoApp">
<head>
	<meta charset="utf-8">
	<title>TO DO LIST</title>
	<meta name="description" content="Tasks Manager by Mattbob">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<link href='http://fonts.googleapis.com/css?family=Oxygen:400,700,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="assets/css/style.min.css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.1.1/animate.min.css">
</head>

<body>

	<nav class="navbar navbar-default" role="navigation">
		<div class="container">
			<div class="navbar-header col-xs-12 col-sm-4 col-md-3">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/angular/">TO DO LIST</a>
			</div>

			<div class="collapse navbar-collapse" id="main-nav">
				<div class="col-sm-8 col-md-9">
					<form class="navbar-form" role="search">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search tasks" data-ng-model="searchFilter">
							<a href="" class="search-clear" data-ng-click="searchFilter = undefined"><span class="glyphicon glyphicon-remove-circle"></span></a>
						</div>
					</form>
				</div>
			</div><!-- .navbar-collapse -->
		</div><!-- .container -->
	</nav>


	<div class="container" data-ng-controller="TodoCtrl">

		<!-- PROJECTS -->
		<div class="projects col-xs-12 col-sm-4 col-md-3">
			<button type="button" class="btn btn-sm btn-block btn-primary btn-newtask" tabindex="1">New Task</button>

			<ul class="nav nav-pills nav-stacked">
				<li data-ng-repeat="project in projects | orderBy:'name'">
					<a href="#" data-ng-click="projectFilter(project.name);console(searchFilter)"><span class="badge pull-right">{{ tasksRemaining(project) }}</span>{{ project.name }}</a>
				</li>
			</ul>

			<form data-ng-submit="addProject()" class="input-group">
				<input class="form-control input-sm" type="text" data-ng-model="projectName" required placeholder="Add a new project">

				<span class="input-group-btn">
					<input class="btn btn-default btn-sm" type="submit" value="Add">
				</span>
			</form>
		</div>

		<!-- TASKS -->
		<div class="tasks col-xs-12 col-sm-8 col-md-9">
			<div class="well animated col-md-12">
				<form data-ng-submit="addTask()" class="form-inline">
					<input class="form-control" type="text" data-ng-model="taskName" required placeholder="Add a new task" tabindex="2">

					<select class="form-control" data-ng-model="taskProject" data-ng-options="project.name for project in projects | orderBy:'name'" required="true" tabindex="3">
						<option value="">Choose A Project</option>
					</select>

					<input type="submit" class="btn btn-primary" value="Add" tabindex="4">
					<button type="button" class="btn btn-link task-clear" tabindex="5"><span class="glyphicon glyphicon-remove-circle"></span></button>
				</form>
			</div>

			<div class="tasks-toolbar btn-toolbar" role="toolbar">
				<div class="tasks-sort-options btn-group btn-group-sm">
					<button type="button" class="btn-remaining btn btn-default active">
						Remaining
					</button>
					<button type="button" class="btn-completed btn btn-default">
						Completed
					</button>
				</div><!-- .tasks-sort-options -->
			</div><!-- .btn-toolbar -->


			<div class="tasks-remaining">
				<table class="table table-striped">
					<thead>
						<tr>
							<th class="cell-check"></th>
							<th class="cell-task"><a href="" data-ng-click="reverse=!reverse; predicate='name'; sortTasks(predicate, reverse)">Task</a></th>
							<th class="cell-project"><a href="" data-ng-click="reverse=!reverse; predicate='project.name'; sortTasks(predicate, reverse)">Project</a></th>
							<th class="cell-options"></th>
						</tr>
					</thead>

					<tbody>
						<tr data-ng-repeat="task in tasks | filter:projectFilterName | filter:searchFilter" data-ng-class="{active: task.done}">
							<td class="cell-check"><input type="checkbox" data-ng-model="task.done" data-ng-change="completeTask(task)"></td>
							<td class="cell-task">{{ task.name }}</td>
							<td class="cell-project">{{ task.project.name }}</td>
							<td class="cell-options">
								<div class="btn-group">
									<!--
									<button type="button" class="btn btn-default btn-xs" data-ng-click="editTask(task)">
										<span class="glyphicon glyphicon-pencil"></span>
									</button>
									-->
									<button type="button" class="btn btn-default btn-xs" data-ng-click="deleteTask(task)">
										<span class="glyphicon glyphicon-trash"></span>
									</button>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div><!-- .tasks-remaining -->


			<div class="tasks-completed">
				<table class="table table-striped">
					<thead>
						<tr>
							<th class="cell-check"></th>
							<th class="cell-task"><a href="" data-ng-click="reverse=!reverse; predicate='name'; sortCompletedTasks(predicate, reverse)">Task</a></th>
							<th class="cell-project"><a href="" data-ng-click="reverse=!reverse; predicate='project.name'; sortCompletedTasks(predicate, reverse)">Project</a></th>
							<th class="cell-options"></th>
						</tr>
					</thead>

					<tbody>
						<tr data-ng-repeat="completedTask in completedTasks | filter:projectFilterName | filter:searchFilter" data-ng-class="{active: completedTask.done}">
							<td class="cell-check"><input type="checkbox" data-ng-model="completedTask.done" data-ng-change="uncompleteTask(completedTask)"></td>
							<td class="cell-task">{{ completedTask.name }}</td>
							<td class="cell-project">{{ completedTask.project.name }}</td>
							<td class="cell-options">
								<div class="btn-group">
									<!--
									<button type="button" class="btn btn-default btn-xs" data-ng-click="editTask(task)">
										<span class="glyphicon glyphicon-pencil"></span>
									</button>
									-->
									<button type="button" class="btn btn-default btn-xs" data-ng-click="deleteCompletedTask(completedTask)">
										<span class="glyphicon glyphicon-trash"></span>
									</button>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div><!-- .tasks-completed -->
		</div><!-- .tasks -->

	</div><!-- .container -->


	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.0-beta.13/angular.min.js"></script>
	<script src="assets/js/plugins/angular-local-storage.min.js"></script>
	<script src="assets/js/main.js"></script>

</body>

</html>