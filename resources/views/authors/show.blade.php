<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Udemy-like Web Development Courses</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            background-color: rgb(233, 238, 230);
            min-height: 100vh;
        }

        .navbar {
            background-color: rgb(233, 238, 230);
            padding: 12px 30px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .title {
            font-size: 28px;
            font-weight: 800;
            color: #7e3d9c;
        }

        .buttons button {
            margin-left: 15px;
            background-color: #7e3d9c;
            color: white;
            font-weight: bold;
            border: none;
            padding: 10px 22px;
            border-radius: 25px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .buttons button:hover {
            background-color: #9b59b6;
        }

        .btn-purple {
            background-color: blue;
            color: #fff;
            border: none;
            transition: 0.3s ease;
        }

        .btn-purple:hover {
            background-color: #9b59b6;
            color: #fff;
        }

        .course-card:hover {
            transform: translateY(-6px);
            transition: all 0.3s ease;
        }

        /* New red container style */
        .congrats-box {
            background-color: rgba(0, 0, 0, 0.2);
            ;
            color: black;
            height: 500px;
            font-size: 30px;
            padding: 40px 20px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);

            /* Center content */
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* vertical center */
            align-items: center;
            /* horizontal center */
            text-align: center;
        }

        
        .btn-subscribe {
            width: 220px;
            height: 60px;
            border-radius: 20px;
            font-size: 22px;
            
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <div class="title">Swivtrek</div>

        <div class="buttons">
            @guest
                <a href="{{ route('login') }}"><button>LOGIN</button></a>
                <a href="{{ route('register') }}"><button>SIGN UP</button></a>
            @endguest

            @auth
                <span>Welcome, {{ Auth::user()->name }}!</span>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit">LOGOUT</button>
                </form>
            @endauth
        </div>
    </div>

    <!-- Main Container -->
    <div class="container py-5">


        <div class="card border-0 shadow-lg rounded-4 overflow-hidden mx-auto" style="max-width: 650px;">
            <div class="card-body p-5 text-center congrats-box">

                <!-- Success Icon -->
                <div class="mb-4">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 70px;"></i>
                </div>

                <!-- Congratulations Message -->
                <h3 class="fw-bold text-dark mb-3">You are now enrolled!</h3>
                <p class="lead text-muted">
                    Enjoy learning <strong class="text-primary">{{ $course }}</strong>.<br>
                    Let’s get started right away 🚀
                </p>

                <!-- Action Buttons -->
                <div class="d-flex flex-column align-items-center gap-3 mt-4 sub">
                    @if(Auth::check() && Auth::user()->subscriptions()->where('course_name', $course)->exists())
                        <a href="{{ route('courses.show', $course) }}" class="btn btn-purple btn-subscribe btn-lg px-4">
                            <i class="bi bi-play-circle me-2"></i> View Course
                        </a>
                    @else
                        <a href="{{ route('courses.purchase', $course) }}" class="btn btn-purple btn-subscribe btn-lg px-4">
                            <i class="bi bi-cart-plus me-2"></i> Subscribe Now
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>

</html>