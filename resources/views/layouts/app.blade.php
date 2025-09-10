<!doctype html>
<html lang="ar">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>لوحة التحكم</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body>
<!-- Top header: ministry name (right) and user info (left) -->
<div class="bg-white border-bottom" style="position: relative; height: 80px;">
  <div class="container-fluid py-2">
<div class="d-flex align-items-center justify-content-center">
  <div class="text-center">
    <img src="/2324.jpg" alt="وزارة الداخلية - مديرية التدريب والتاهيل" style="position: absolute; top: 10px; left: 0; width: 100%; height: 200px;; object-fit:fill ; z-index: 1; background-color: white;">
  </div>
  <div class="position-absolute end-0 d-flex align-items-center gap-2" style="z-index: 2;">
    @auth
      @php $gravatar = 'https://www.gravatar.com/avatar/' . md5(strtolower(trim(auth()->user()->email))) . '?s=48&d=mp'; @endphp
      <div class="dropdown" style="margin-top: 150px">
        <a class="d-flex align-items-center text-decoration-none dropdown-toggle" href="#" id="userMenuHeader" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="{{ $gravatar }}" alt="avatar" class="rounded-circle" width="40" height="40">
          <div class="d-none d-md-block ms-2 text-start" >
            <div style="font-weight:700; color:red; font-size:18px;">{{ auth()->user()->name }}</div>
            <div  style="font-weight:700; color:white; font-size:18px;">{{ auth()->user()->email }}</div>
          </div>
        </a>
        <ul class="dropdown-menu" aria-labelledby="userMenuHeader">
          <li><a class="dropdown-item" href="/profile">عرض الملف الشخصي</a></li>
          <li><a class="dropdown-item" href="/profile/password">تغيير كلمة المرور</a></li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="dropdown-item text-danger" type="submit">تسجيل خروج</button>
            </form>
          </li>
        </ul>
      </div>
    @endauth
  </div>
</div>
  </div>
</div>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4" style="margin-top: 130px">
  <div class="container-fluid">

    <button class="btn btn-outline-secondary ms-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
      &#9776;
    </button>
   <a class="navbar-brand" href="#">   برنامج ادارة المتقدمين للدراسات العليا خارج العراق   </a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
      @auth

      @else
        <li class="nav-item">
          <a class="btn btn-sm btn-primary me-2" href="{{ route('login') }}">دخول</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-sm btn-outline-primary" href="{{ route('register') }}">تسجيل</a>
        </li>
      @endauth
      </ul>
    </div>
  </div>
</nav>

<div class="container">
  <div class="row">
    @auth
      <div class="col-12">
        <!-- Offcanvas sidebar -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
          <div class="offcanvas-header">
            <h5 id="sidebarLabel">القائمة</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body p-0">
            <div class="list-group list-group-flush">
              <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action d-flex align-items-center btn btn-light text-start">
                <span class="me-2">🏠</span> لوحة التحكم
              </a>
              <a href="{{ route('form.create') }}" class="list-group-item list-group-item-action d-flex align-items-center btn btn-light text-start">
                <span class="me-2">✍️</span> نموذج إدخال
              </a>
              <a href="{{ route('applicants.index') }}" class="list-group-item list-group-item-action d-flex align-items-center btn btn-light text-start">
                <span class="me-2">📋</span> المتقدمين
              </a>
              @if(auth()->user()->isAdmin())
              <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action d-flex align-items-center btn btn-light text-start">
                <span class="me-2">👥</span> إدارة المستخدمين
              </a>
              @endif
            </div>
          </div>
        </div>

        <main class="p-3">
          @yield('content')
        </main>
      </div>
    @else
      <div class="col-md-12">
        @yield('content')
      </div>
    @endauth
  </div>
</div>
  <!-- global alerts (single place) -->
  @if(session('success'))
    <div class="container mt-3">
      <div class="alert alert-success">{{ session('success') }}</div>
    </div>
  @endif
  @if($errors->any())
    <div class="container mt-3">
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  @endif

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  @yield('scripts')
</body>
</html>
