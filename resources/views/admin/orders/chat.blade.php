@extends('admin.layout.master')

@section('content')



<div class="card direct-chat direct-chat-primary">
    <div class="card-header ui-sortable-handle" style="cursor: move;">
      <h3 class="card-title">گفتگو</h3>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <!-- Conversations are loaded here -->
      <div>
        <!-- Message. Default to the left -->
        <div class="direct-chat-msg">
          <div class="direct-chat-info clearfix">
            <span class="direct-chat-name float-left">محمدرضا عطوان</span>
            <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
          </div>
          <!-- /.direct-chat-info -->
          <img class="direct-chat-img" src="dist/img/user1-128x128.jpg" alt="message user image">
          <!-- /.direct-chat-img -->
          <div class="direct-chat-text">
            واقعا این قالب رایگانه ؟ قابل باور نیست
          </div>
          <!-- /.direct-chat-text -->
        </div>
        <!-- /.direct-chat-msg -->

        <!-- Message to the right -->
        <div class="direct-chat-msg right">
          <div class="direct-chat-info clearfix">
            <span class="direct-chat-name float-right">سارا</span>
            <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
          </div>
          <!-- /.direct-chat-info -->
          <img class="direct-chat-img" src="dist/img/user3-128x128.jpg" alt="message user image">
          <!-- /.direct-chat-img -->
          <div class="direct-chat-text">
            بهتره اینو باور کنی :)
          </div>
          <!-- /.direct-chat-text -->
        </div>
        <!-- /.direct-chat-msg -->

        <!-- Message. Default to the left -->
        <div class="direct-chat-msg">
          <div class="direct-chat-info clearfix">
            <span class="direct-chat-name float-left">محمدرضا عطوان</span>
            <span class="direct-chat-timestamp float-right">23 Jan 5:37 pm</span>
          </div>
          <!-- /.direct-chat-info -->
          <img class="direct-chat-img" src="dist/img/user1-128x128.jpg" alt="message user image">
          <!-- /.direct-chat-img -->
          <div class="direct-chat-text">
            میخوام با این قالب یه اپلیکیشن باحال بزنم ؟&zwnj; تو هم همکاری میکنی ؟
          </div>
          <!-- /.direct-chat-text -->
        </div>
        <!-- /.direct-chat-msg -->

        <!-- Message to the right -->
        <div class="direct-chat-msg right">
          <div class="direct-chat-info clearfix">
            <span class="direct-chat-name float-right">سارا</span>
            <span class="direct-chat-timestamp float-left">23 Jan 6:10 pm</span>
          </div>
          <!-- /.direct-chat-info -->
          <img class="direct-chat-img" src="dist/img/user3-128x128.jpg" alt="message user image">
          <!-- /.direct-chat-img -->
          <div class="direct-chat-text">
            اره حتما
          </div>
          <!-- /.direct-chat-text -->
        </div>
        <!-- /.direct-chat-msg -->

      </div>
      <!--/.direct-chat-messages-->

      <!-- Contacts are loaded here -->
      <div class="direct-chat-contacts">
        <ul class="contacts-list">
          <li>
            <a href="#">
              <img class="contacts-list-img" src="dist/img/user1-128x128.jpg">

              <div class="contacts-list-info">
                <span class="contacts-list-name">
                  محمدرضا عطوان
                  <small class="contacts-list-date float-left">1397/10/01</small>
                </span>
                <span class="contacts-list-msg">تا حالا کجا بودی ؟&zwnj;من...</span>
              </div>
              <!-- /.contacts-list-info -->
            </a>
          </li>
          <!-- End Contact Item -->
          <li>
            <a href="#">
              <img class="contacts-list-img" src="dist/img/user7-128x128.jpg">

              <div class="contacts-list-info">
                <span class="contacts-list-name">
                  سارا فرهانی
                  <small class="contacts-list-date float-left">2/23/2015</small>
                </span>
                <span class="contacts-list-msg">تا حالا منتظر تو بودم...</span>
              </div>
              <!-- /.contacts-list-info -->
            </a>
          </li>
          <!-- End Contact Item -->
          <li>
            <a href="#">
              <img class="contacts-list-img" src="dist/img/user3-128x128.jpg">

              <div class="contacts-list-info">
                <span class="contacts-list-name">
                  نکیسا کیانی
                  <small class="contacts-list-date float-left">2/20/2015</small>
                </span>
                <span class="contacts-list-msg">پس بیشتر صبر کن تا برگردم...</span>
              </div>
              <!-- /.contacts-list-info -->
            </a>
          </li>
          <!-- End Contact Item -->
          <li>
            <a href="#">
              <img class="contacts-list-img" src="dist/img/user5-128x128.jpg">

              <div class="contacts-list-info">
                <span class="contacts-list-name">
                  رحمت موسوی
                  <small class="contacts-list-date float-left">2/10/2015</small>
                </span>
                <span class="contacts-list-msg"> حالتون چطورههههه !...</span>
              </div>
              <!-- /.contacts-list-info -->
            </a>
          </li>
          <!-- End Contact Item -->
          <li>
            <a href="#">
              <img class="contacts-list-img" src="dist/img/user6-128x128.jpg">

              <div class="contacts-list-info">
                <span class="contacts-list-name">
                  جکسون عبداللهی
                  <small class="contacts-list-date float-left">1/27/2015</small>
                </span>
                <span class="contacts-list-msg">عالیییییییییی...</span>
              </div>
              <!-- /.contacts-list-info -->
            </a>
          </li>
          <!-- End Contact Item -->
          <li>
            <a href="#">
              <img class="contacts-list-img" src="dist/img/user8-128x128.jpg">

              <div class="contacts-list-info">
                <span class="contacts-list-name">
                  کتایون ریحانی
                  <small class="contacts-list-date float-left">1/4/2015</small>
                </span>
                <span class="contacts-list-msg">بیخیالش پیداش میکنم...</span>
              </div>
              <!-- /.contacts-list-info -->
            </a>
          </li>
          <!-- End Contact Item -->
        </ul>
        <!-- /.contacts-list -->
      </div>
      <!-- /.direct-chat-pane -->
    </div>
    <!-- /.card-body -->
  </div>
@endsection
