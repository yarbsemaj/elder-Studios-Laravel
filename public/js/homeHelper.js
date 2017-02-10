//Toaster options
memberPath = "edit";
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "500",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

//Leaderboard
var app = angular.module('hudScrabble', []);

app.controller('leaderBoard', function ($scope, $http) {
    $http.get("/api/leaderBoard")
        .then(function (response) {
            $scope.scores = response.data;
        });
});


app.controller('memberInfo', function ($scope, $http) {
    //Member cRud
    $scope.showMemberInfo = function ($event) {
        $http({
            url: '/api/playerInfo',
            method: "POST",
            data: { 'memberID': $scope.memberID },
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            transformRequest: function (obj) {
                var str = [];
                for (var p in obj)
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                return str.join("&");
            }
        }).then(function (response) {
            console.log(response.data);
            if (response.data.success) {
                memberPath = "edit";
                if (response.data.memberData.gamesPlayed != 0) {
                    $scope.opScore = response.data.bestGame.opScore;
                    $scope.playerScore = response.data.bestGame.playerScore;
                    $scope.location = response.data.bestGame.location;
                    $scope.opName = response.data.bestGame.opName;
                    $scope.time = new Date(response.data.bestGame.time);
                    $scope.loss = response.data.memberData.loss;
                    $scope.avg = response.data.memberData.avg;
                    $scope.wins = response.data.memberData.wins;
                }
                $scope.gamesPlayed = response.data.memberData.gamesPlayed;
                $("#playerInfo").modal();

                $scope.joinDate = new Date(response.data.memberData.joinDate);
                $scope.name = response.data.memberData.name;
                $scope.adress1 = response.data.memberData.adress1;
                $scope.adress2 = response.data.memberData.adress2;
                $scope.postCode = response.data.memberData.postCode;
                $scope.memberID = response.data.memberData.memberID;
                $scope.mode = "edit";

            } else {
                toastr["error"]("The Member ID your looking for is invalid");
            }


        });
    }
    //Member CrUd
    $scope.saveMember = function ($event) {
        $http({
            url: '/api/' + memberPath + 'Member',
            method: "POST",
            data: { 'memberID': $scope.memberID, 'name': $scope.name, 'adress1': $scope.adress1, 'adress2': $scope.adress2, 'postCode': $scope.postCode },
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            transformRequest: function (obj) {
                var str = [];
                for (var p in obj)
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                return str.join("&");
            },
        }).then(function (response) {
            console.log(response.data);
            if (response.data.success) {
                console.log(response.data);
                $("#editModal").modal('toggle');
                toastr["info"]("Member ID " + response.data.memberID + " successfully " + $scope.mode + "ed");
            } else {
                toastr["error"]("A generic error has ocured");
            }


        });
    }

    $scope.addMember = function ($event) {
        memberPath = "add";
        $scope.name = "";
        $scope.adress1 = "";
        $scope.adress2 = "";
        $scope.postCode = "";
        $scope.memberID = "";
        $scope.mode = "add";
        $("#editModal").modal();
    }
});
//tooltip fix
app.directive('tooltip', function () {
    return {
        link: function (scope, element, attrs) {
            $(element).hover(function () {
                // on mouseenter
                $(element).tooltip('show');
            }, function () {
                // on mouseleave
                $(element).tooltip('hide');
            });
        }
    };
});
//capitalize
app.filter('capitalize', function () {
    return function (input) {
        return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
    }
});

//smoothScroll

$(function () {
    $('a[href*="#"]:not([href="#"], .carousel-control)').click(function () {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 1000);
                return false;
            }
        }
    });
});