!function (e, t) {
    angular.module("widgetkit").service("mediaPicker", [
            "$location",
            "$q",
            "Application",
            function (e, t, n) {
                return {
                    select: function (n) {
                        var a = t.defer();
                        mihaildev.elFinder.openManager({
                            "url": "admin/file-manager-elfinder/manager?callback=contentarticles-title&lang=ru",
                            "width":"auto",
                            "height":"auto",
                            "id":"contentarticles-title"
                        });

                        mihaildev.elFinder.register("contentarticles-title", function(file, id) {
                            a.resolve(file);
                            return true;
                        });
                        return a.promise
                    }
                }
            }
        ]
    )
}(jQuery, window);
