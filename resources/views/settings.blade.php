@extends('layouts.admin')

@section('title','Settings')

@section('script')

@endsection

@section('style')
<style type="text/css">
.link.items .item:hover {
  background-color: rgba(180,360,360,0.2);
}
</style>
@endsection

@section('content')

  <div class="ui basic segment content"> 
    <h1 class="ui right floated header">
      <i class="settings icon"></i>
      <div class="content">Settings</div>
    </h1>

    <div class="ui clearing divider"></div>

    <div class="ui stacked very padded segment">
      <div class="ui grid stackable">

        <div class="three column row">
          <div class="column">
            <div class="ui link items">
              <a href="Settings/General" class="item">
                <div class="ui tiny image">
                  <!-- <i class="plug icon"></i> -->
                  <img src="/generalpics/preview.png">
                </div>
                <div class="content">
                  <div class="header">General</div>
                  <div class="description">
                    View and update your store details.
                  </div>
                </div>
              </a>
            </div>
          </div>
          <div class="column">
            <div class="ui link items">
              <a href="Settings/Site" class="item">
                <div class="ui tiny image">
                  <!-- <i class="plug icon"></i> -->
                  <img src="/generalpics/preview.png">
                </div>
                <div class="content">
                  <div class="header">Site Settings</div>
                  <div class="description">
                    View and update your Site.
                  </div>
                </div>
              </a>
            </div>
          </div>
          <div class="column">
            <div class="ui link items">
              <a href="Settings/Users" class="item">
                <div class="ui tiny image">
                  <img src="/generalpics/preview.png">
                </div>
                <div class="content">
                  <div class="header">Users</div>
                  <div class="description">
                    Add Update users.
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
        
      </div>
    </div>

  </div>

@endsection