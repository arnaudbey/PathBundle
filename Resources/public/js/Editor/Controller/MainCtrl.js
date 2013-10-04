'use strict';

/**
 * Main Controller
 */
var MainCtrlProto = [
    '$scope',
    '$routeParams',
    '$location',
    '$http',
    '$modal',
    'HistoryFactory',
    'ClipboardFactory',
    'PathFactory',
    'StepFactory',
    function($scope, $routeParams, $location, $http, $modal, HistoryFactory, ClipboardFactory, PathFactory, StepFactory) {
        // Store symfony base partials route
        $scope.webDir = EditorApp.webDir;
        
        // Set active tab
        $scope.activeTab = 'Global';
        $scope.$on('$routeChangeSuccess', function(event, current, previous) {
            $scope.activeTab = current.activeTab;
        });
        
        // Load current path
        if (EditorApp.pathId) {
            // Edit existing path
            $http.get(Routing.generate('innova_path_get_path', {id: EditorApp.pathId}))
                 .success(function (data) {
                    $scope.path = data;
                    PathFactory.setPath($scope.path);
                    
                    if ($scope.path.steps.length === 0) {
                        // Missing root step => add it
                        var rootStep = StepFactory.generateNewStep();
                        rootStep.name = $scope.path.name;
                        $scope.path.steps.push(rootStep);
                    }
                
                    // Update History if needed
                    if (-1 === HistoryFactory.getHistoryState()) {
                        HistoryFactory.update($scope.path);
                    }
                 })
                 .error(function(data, status) {
                    // TODO
                 });
        }
        else {
            // Create new path
            $scope.path = PathFactory.generateNewPath();
            PathFactory.setPath($scope.path);
            
            if ($scope.path.steps.length === 0) {
                // Missing root step => add it
                var rootStep = StepFactory.generateNewStep();
                rootStep.name = $scope.path.name;
                $scope.path.steps.push(rootStep);
            }
            
            // Update History if needed
            if (-1 === HistoryFactory.getHistoryState()) {
                HistoryFactory.update($scope.path);
            }
        }
        
        /**
         * Open Help modal
         * @returns void
         */
        $scope.openHelp = function() {
            var modalInstance = $modal.open({
                templateUrl: EditorApp.webDir + 'js/Help/Partial/help.html',
                controller: 'HelpModalCtrl'
            });
        };
        
        
        /**
         * Copy data into clipboard
         * @returns void
         */
        $scope.copy = function(data) {
            ClipboardFactory.copy(data);
        };
        
        /**
         * Paste current clipboard content
         * @returns void
         */
        $scope.paste = function(step) {
            ClipboardFactory.paste(step);
            HistoryFactory.update($scope.path);
        };
        
        /**
         * Undo last user modifications
         * @returns void
         */
        $scope.undo = function() {
            HistoryFactory.undo();
            $scope.path = PathFactory.getPath();
        };
        
        /**
         * Redo last history modifications
         * @returns void
         */
        $scope.redo = function() {
            HistoryFactory.redo();
            $scope.path = PathFactory.getPath();
        };
        
        /**
         * Save Path modifications in DB
         * @returns void
         * 
         * @todo add confirm messages
         */
        $scope.save = function(path) {
            var method = null;
            var route = null;
            var data = 'pathName=' + path.name + '&path=' + angular.toJson(path) + '&workspaceId=' + EditorApp.workspaceId;
            
            if (EditorApp.pathId) {
                // Update existing path
                method = 'PUT';
                route = Routing.generate('innova_path_edit_path', {id: EditorApp.pathId});
            }
            else {
                // Create new path
                method = 'POST';
                route = Routing.generate('innova_path_add_path');
            }

            $http({
                method: method,
                url: route,
                headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
                data: data
            })
            .success(function (data) {
                if (EditorApp.pathId) {
                    // Update success
                    alert('updated');
                }
                else {
                    // Create success
                    alert('created');
                }
            })
            .error(function(data, status) {
                // TODO
            });
            
            // Clear history to avoid possibility to get a history state without path ID
            HistoryFactory.clear();
        };
    }
];