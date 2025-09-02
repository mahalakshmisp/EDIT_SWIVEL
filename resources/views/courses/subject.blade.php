<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Udemy-like Web Development Courses</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: rgb(233, 238, 230);

        }

        /* Custom styles for Bestseller and badges */
        .badge-bestseller {
            @apply bg-teal-200 text-teal-800 font-semibold text-xs px-2 py-0.5 rounded;
        }

        .badge {
            @apply text-xs bg-gray-100 text-gray-700 px-2 py-0.5 rounded mr-2 mb-2 inline-block;
        }

        .badge-star {
            @apply flex items-center gap-1 text-xs bg-yellow-100 text-yellow-800 font-semibold px-2 py-0.5 rounded mr-2 mb-2 inline-block;
        }

        .price {
            font-weight: 700;
            font-size: 1.125rem;
        }

        .btn-add-cart {
            @apply border border-purple-600 text-purple-600 font-semibold px-4 py-1.5 rounded hover:bg-purple-600 hover:text-white transition;
        }

        .btn-add-cart {
            /* background-color: red; */
            color: rgb(122, 61, 219);
            width: 100px;
            font-weight: bolder;
            border: 2px solid rgb(122, 61, 219);
            border-radius: 5px;
        }

        .btn-add-cart:hover {
            background-color: rgb(230, 226, 237);
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

        .card-highlight {
            border-color: #fbbf24;
            /* amber-400 */
        }

        .display-5 {
            font-size: 30px;
        }

        .leading-tight {
            font-size: 30px;
            text-align: center;
        }

        .price{
            font-size: 24px;
        }
    </style>
</head>

<body class=" min-h-screen font-sans text-gray-900 background-color: rgb(233, 238, 230);
">
    <div class="navbar">
        <div class="title">Swivtrek</div>

        <div class="buttons">
            @guest
                {{-- Show only for visitors who are not logged in --}}
                <a href="{{ route('login') }}"><button>LOGIN</button></a>
                <a href="{{ route('register') }}"><button>SIGN UP</button></a>
            @endguest

            @auth
                {{-- Show logged-in user's name --}}
                <span>Welcome, {{ Auth::user()->name }}!</span>

                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit">LOGOUT</button>
                </form>
            @endauth
        </div>


    </div>
    <main class="max-w-7xl mx-auto p-4">
        <h2 class="display-5 fw-bold">Subject: <span class="text-primary">{{ ucfirst($subject) }}</span></h2><br>
        <section class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @foreach($courses as $course)
                <article class="bg-white rounded-lg shadow-md p-4 border hover:shadow-lg transition flex flex-col">
                    <div class="overflow-hidden rounded-md">
                        <img src="{{ $course->image ?? 'https://placehold.co/600x300?text=No+Image' }}"
                            alt="{{ $course->course_name }}" class="w-full h-48 object-cover"
                            onerror="this.onerror=null;this.src='https://placehold.co/600x300?text=Image+not+found'" />
                    </div>

                    <h2 class="mt-3 font-bold leading-tight">{{ $course->course_name }}</h2>

                    <h4 class="text-lg text-gray-600 mb-3 author">
                        <strong>Author:</strong> {{ $course->author_name ?? 'Unknown' }}
                    </h4>

                    <div class="flex flex-wrap items-center mb-3 space-x-2">
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-0.5 text-xs rounded">Duration:</span>
                        <span class="text-xs bg-gray-100 text-gray-700 px-2 py-0.5 rounded">
                            {{ $course->hours ?? 'N/A' }} total hours
                        </span>
                    </div>

                    <div class="mt-auto flex items-center justify-between">
                        <p class="price font-bold text-gray-800"><span>Price</span> : ₹ {{ $course->price ?? '0' }}</p>
                        <a href="{{ route('authors.show', $course->course_name) }}" class="btn-add-cart text-center py-2">
                            Buy Now
                        </a>
                    </div>
                </article>
            @endforeach
        </section>
    </main>
</body>

</html>