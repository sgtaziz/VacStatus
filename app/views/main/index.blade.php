@extends('layout')

@section('content')
  @if(!Auth::check() || Auth::User()->UserMail == null || !Auth::User()->UserMail->canMail())
  <div data-alert class="alert-box success ">
    You can now recieve notifications! <a style="color:white; text-decoration:underline;" href="https://vacstat.us/news/12">Email &amp; Subscription implemented</a>
  </div>
  @endif


  <div class="large-12 columns vacstatus-index-box">
    <h2 class="text-center">Welcome to VacStatus<br><small>Keep track of people's VAC status in a list</small></h2>
  @if(!Auth::check())
    <div data-alert class="alert-box vacstatus-alert-box">
      <p>In a game like Counter-Strike: Global Offensive, you do not get a notification of some sort when the hacker gets banned. With VacStatus, you can now can keep in check of the possible hacker you reported and when that hacker gets banned, you can even recieve an email notification!</p>
      <div class="row text-center vacstatus-about-box" data-equalizer>
        <div class="large-3 medium-3 columns" data-equalizer-watch>
          <h2><i class="fa fa-heart"></i></h2>
          <p><b>Free &amp; Open Source</b><br>Yup. It's free and anyone can look at the code that is making this website run!</p>
        </div>
        <div class="large-3 medium-3 columns" data-equalizer-watch>
          <h2><i class="fa fa-unlock"></i></h2>
          <p><b>No Registration Required</b><br>Registration isn't required to use the website, but it is recommended.</p>
        </div>
        <div class="large-3 medium-3 columns" data-equalizer-watch>
          <h2><i class="fa fa-steam"></i></h2>
          <p><b>Steam Integrated</b><br>Login with steam to create &amp; manage your list! You can also view your friend's list too!</p>
        </div>
        <div class="large-3 medium-3 columns" data-equalizer-watch>
          <h2><i class="fa fa-user"></i></h2>
          <p><b>Detailed Profiles</b><br>We provide detailed information about any users you lookup.</p>
        </div>
      </div>
      <div class="row text-center vacstatus-about-box" data-equalizer>
        <div class="large-3 medium-3 columns" data-equalizer-watch>
          <h2><i class="fa fa-share-alt"></i></h2>
          <p><b>Create &amp; Share Your List</b><br>Create a list to keep record of the hackers you meet &amp; share them with your friends!</p>
        </div>
        <div class="large-3 medium-3 columns" data-equalizer-watch>
          <h2><i class="fa fa-list"></i></h2>
          <p><b>Create Multiple Lists</b><br>One list isn't enough? Well, you can donate to create more than 1 list!</p>
        </div>
        <div class="large-3 medium-3 columns" data-equalizer-watch>
          <h2><i class="fa fa-users"></i></h2>
          <p><b>Comment System</b><br>Found a hacker or a scammer? Leave a comment to warn others!</p>
        </div>
        <div class="large-3 medium-3 columns" data-equalizer-watch>
          <h2><i class="fa fa-book"></i></h2>
          <p><b>Simple to Use</b><br>Login and start putting people on the list to track right away!</p>
        </div>
      </div>
      <!-- <a href="#" class="close">&times;</a> -->
    </div>
  @else
  <div style="height: 10px"></div>
  @endif
  </div>

  <div class="row index-wrapper" data-equalizer>

    <div class="large-8 medium-8 columns vacstatus-multilist list-display-wrapper" data-equalizer-watch>
      <ul class="tabs">
        <li class="tab-title"><a href="{{{ URL::route('list_display', 'most') }}}">Most Tracked</a></li>
        <li class="tab-title"><a href="{{{ URL::route('list_display', 'last') }}}">Latest Added</a></li>
        @if(Auth::check())
        <li class="tab-title">
          <div data-dropdown="personalList">Personal List <i class="fa fa-caret-down"></i></div>
          <ul id="personalList" class="f-dropdown" data-dropdown-content>
            @foreach(Auth::User()->UserList()->orderBy('id', 'DESC')->get() as $UserList1)
            <li><a href="{{{ URL::route('list_display', array($UserList1->user_id, $UserList1->id)) }}}">{{{ $UserList1->getTitle() }}}</a></li>
            @endforeach
            <li class="divider"></li>
            <li><a data-reveal-id="addList">New List</a></li>
          </ul>
        </li>
        <li class="tab-title">
          <div data-dropdown="friendsList">Friends' List <i class="fa fa-caret-down"></i></div>
          <ul id="friendsList" class="f-dropdown" data-dropdown-content>
            @foreach($friendsList as $friends)
            @if($friends->UserList()->count() > 0)
            <li class="has-dropdown">
              <a>{{{ $friends->getUserName() }}}</a>
              <ul class="dropdown">
                @foreach($friends->UserList()->where('privacy','!=','3')->orderBy('id', 'DESC')->get() as $friendsList)
                <li class="right">
                  <a href="{{{ URL::route('list_display', array($friendsList->user_id, $friendsList->id)) }}}">{{{ $friendsList->getTitle() }}}</a>
                </li>
                @endforeach
              </ul>
            </li>
            @endif
            @endforeach
          </ul>
        </li>
        @endif
      </ul>
      <div class="tabs-content">
        <div class="list-display content active">
          @if(isset($userMail))
            @include('list/listTable', array( 'userList' => $userList, 'userMail' => $userMail, 'subscription' => $subscription ))
          @else
            @include('list/listTable', array( 'userList' => $userList ))
          @endif
        </div>
      </div>
    </div>

    <div class="large-4 medium-4 columns vacstatus-news" data-equalizer-watch>
      <h5>News &amp; Updates</h5>
      <ul>
      @foreach($news as $article)
        <li><span>{{{ date('m/d/Y', strtotime($article->created_at)) }}}&nbsp;&mdash;</span>&nbsp;<a href="{{{ URL::route('news', $article->id) }}}">{{{ $article->title }}}</a></li>
      @endforeach
      </ul>
    </div>
  </div>

@stop
