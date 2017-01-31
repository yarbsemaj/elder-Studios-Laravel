<html ng-app="hudScrabble">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
  <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.0rc1/angular-route.min.js"></script>
  <script src="/js/toastr.min.js"></script>
  <script src="/js/homeHelper.js"></script>
  <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="css\main.css" rel="stylesheet" type="text/css">
  <link href="css/toastr.min.css" rel="stylesheet" type="text/css">
  <title>Huddersfield Scrabble Club</title>
</head>

<body>
  <div class="cover">
    <div class="navbar navbar-default" style=" background-color: #fff !important; border-radius:0px">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><span>Hud Scrabble</span></a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-ex-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="active">
              <a href="#members">Members</a>
            </li>
            <li>
              <a href="#leaderBoard">Leader Board</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="background-image-fixed cover-image" style="background-image : url('img/background.jpg')"></div>
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center" style="color:#fff">
          <h1>Huddersfield Scrabble Club</h1>
          <h2>It's all fun and games untill someone loses an I...</h2>
        </div>
      </div>
    </div>
  </div>
  <div class="section">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1 id="leaderBoard">Leader Board</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 center-block" style="float: none">
          <div ng-controller="leaderBoard">
            <ul class="list-group">
              <li class="list-group-item" ng-repeat="x in scores">
                <div data-toggle="tooltip" title="Games Played: {{x.gamesPlayed}}" tooltip="" style="width: 100%; font-weight: bold">{{$index + 1}}. {{ x.name }}
                  <span class="badge" style="float: right">{{x.avgScore}}</span>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div ng-controller="memberInfo">
    <div class="section text-center">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 id="members" class="text-left">Members</h1>
            <div class="container">
              <div class="col-lg-6 center-block" style="float: none">
                <div class="input-group">
                  <input ng-model="memberID" class="form-control" placeholder="Membership ID">
                  <input type="hidden" name="_token" value="<?php echo csrf_token() ?>" />
                  <span class="input-group-btn">
<button ng-click="showMemberInfo()" class="btn btn-primary">Lookup<i class="fa fa-fw fa-search"></i>
</button>
</span>
                </div>
              </div>
              <br>
              <H3 class="text-left">New Member?</H3>
              <br>
              <button ng-click="addMember()" class="btn btn-lg btn-primary">Add Member
                <i class="fa fa-fw fa-plus "></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="playerInfo" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="modelTitleId">Player Profile</h4>
          </div>
          <div class="modal-body">
            <h2 class="text-muted">{{name}}</h2>
            <h4>{{joinDate * 1000 | date:'d MMMM y'}}</h4>
            <p>{{adress1}}</p>
            <p>{{adress2}}</p>
            <p>{{postCode}}</p>
            <div ng-show="gamesPlayed > 0">
              <div class="row">
                <div class="col-md-4 text-center">
                  <h1 class="text-center text-success">Wins
<i class="fa fa-fw fa-thumbs-up"></i>
</h1>
                  <h3>{{wins}}</h3>
                </div>
                <div class="col-md-4 text-center">
                  <h1 class="text-center">Average</h1>
                  <h3>{{avg}}</h3>
                </div>
                <div class="col-md-4 text-center">
                  <h1 class="text-center text-danger">Losses
<i class="fa fa-fw fa-close"></i>
</h1>
                  <h3>{{loss}}</h3>
                </div>
              </div>
              <h1>Best Game</h1>
              <div class="row">
                <div class="col-md-4 text-center">
                  <h1 class="text-center">{{playerScore}}</h1>
                </div>
                <div class="col-md-4 text-center">
                  <h1 class="text-center">To</h1>
                </div>
                <div class="col-md-4 text-center">
                  <h1 class="text-center">{{opScore}}</h1>
                </div>
              </div>
              <h3 class="text-muted">Against</h3>
              <p>{{opName}} at {{location}} on {{time * 1000 | date:'d MMMM y h:m a'}}</p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#editModal">Edit</button>
          </div>
        </div>
      </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
      <form name="editMember">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modelTitleId"> {{mode | capitalize}} member</h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="Name">Name</label>
                <input ng-model="name" type="text" class="form-control" name="name" id="" aria-describedby="helpId" placeholder="Member Name" required>
                <small id="helpId" ng-show="editMember.name.$error.required && editMember.name.$dirty" class="form-text text-error">Please enter a member name</small>
              </div>

              <div class="form-group">
                <label for="">Adress</label>
                <input ng-model="adress1" type="text" class="form-control" name="adress1" id="" aria-describedby="helpId" placeholder="Adress Line 1" required>
                <br>
                <input ng-model="adress2" type="text" class="form-control" name="adress2" id="" aria-describedby="helpId" placeholder="Adress Line 2" required>
                <br>
                <input ng-model="postCode" type="text" class="form-control" name="postCode" id="" aria-describedby="helpId" placeholder="Post Code" required>
                <small id="helpId" ng-show="editMember.adress1.$error.required && editMember.adress1.$dirty ||
editMember.adress2.$error.required && editMember.adress2.$dirty ||
editMember.postCode.$error.required && editMember.postCode.$dirty" class="form-text text-error">Please enter a valid adress</small>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" ng-click="saveMember()" ng-disabled="editMember.$invalid">Save</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</body>

</html>