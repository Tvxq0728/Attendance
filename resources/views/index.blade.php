<!DOCTYPE html>
<html lang="js">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>打刻画面</title>
</head>
<body>
  <div class="header">
    <div class="header_title">
      <header><h1>Atte</h1></header>
    </div>
    <div class="header_nav">
      <ul>
        <li><a href="/">ホーム</a></li>
        <li><a href="/attendance">日付一覧表</a></li>
        <form action="{{ route('logout') }}">
          <li>
            <x-dropdown-link :href="route('logout')"
            onclick="event.preventDefault();
            this.closest('form').submit();">
            {{__('ログアウト')}}
            </x-dropdown-link>
          </li>
        </form>
      </ul>
    </div>
  </div>
  <div class="content">
    <div class="user_list">
      <p class="user_list-title">
        {{$user->name}}さん　お疲れ様です。
      </p>
    </div>
    <div class="session">
      <p>
        {{session('message')}}
      </p>
    </div>
    <div class="content_stampbtn">
      <form action="/stamp/start" method="POST">
        @csrf
        @if(Session::has("start"))
        <button type="submit" class="btn_disabled">
          勤務開始
        </button>
        @else
        <button type="submit">
          勤務開始
        </button>
        @endif
      </form>
      <form action="/stamp/end" methods="POST">
        @csrf
        @if(Session::has('end'))
        <button type="submit" disabled>
          勤務終了
        </button>
        @else
        <button type="submit">
          勤務終了
        </button>
        @endif
      </form>
    </div>
    <div class="content_stampbtn">
      <form action="/rest/start" methods="POST">
        @csrf
        @if(Session::has("rest_start"))
        <button type="submit" class="btn_disabled">
          休憩開始
        </button>
        @else
        <button type="submit">
          休憩開始
        </button>
        @endif
      </form>
      <form action="/rest/end" methods="POST">
        @csrf
        @if(Session::has("rest_end"))
        <button type="submit"
        class="btn_disabled">
          休憩終了
        </button>
        @else
        <button type="submit" class="btn" id="btn_start">
          休憩終了
        </button>
        @endif
      </form>
    </div>
  </div>
  <div class="footer">
    <footer>Atte.inc</footer>
  </div>
</body>
</html>
<style>
/* 全て */
  *{
    color:black;
  }
  body{

  }
/* ヘッダー */
  .header{
    display:flex;
    justify-content:space-between;
    align-items:center;
  }
  .header_nav{
    width:40%;
  }
  .header_nav ul{
    display:flex;
    justify-content:space-around;
  }
  .header_nav ul li{
    list-style:none;
  }
  .header_nav ul li a:hover{
    color:red;
  }
  .header_nav a{
    text-decoration:none;
  }
  /* ユーザータイトル */
  .user_list-title{
    font-weight:bold;
    text-align:center;
    padding-top:30px;
  }
/* 打刻 */
  .content{
    background:#F5F5F5;
    height:auto;
  }
  .content_stampbtn{
    display:flex;
    justify-content:space-around;
    padding:20px 0;
  }
  .content button{
    border:none;
    padding:60px 120px;
    background:white;
    font-weight:bold;
  }
  .btn_disabled{
    border-color:red;
    border-radius:10px;
  }
/* フッター */
  .footer{
    text-align:center;
  }
</style>