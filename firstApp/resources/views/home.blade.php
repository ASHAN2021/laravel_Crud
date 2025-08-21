<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel CRUD - Blog Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    @auth
        <!-- Navigation Header -->
        <nav class="bg-white shadow-lg border-b-4 border-indigo-500">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <i class="fas fa-blog text-2xl text-indigo-600 mr-3"></i>
                        <h1 class="text-xl font-bold text-gray-800">StoryNest</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">Welcome back!</span>
                        <form action="/logout" method="POST" class="inline">
                            @csrf
                            <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Create Post Section -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                        <div class="flex items-center mb-6">
                            <i class="fas fa-plus-circle text-2xl text-indigo-600 mr-3"></i>
                            <h2 class="text-xl font-semibold text-gray-800">Create New Post</h2>
                        </div>
                        <form action="/create-post" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Post Title</label>
                                <input type="text" name="title" placeholder="Enter your post title..." 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                                <textarea name="body" rows="6" placeholder="Write your post content here..."
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 resize-none"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white py-3 px-4 rounded-lg font-medium transition duration-200 flex items-center justify-center">
                                <i class="fas fa-save mr-2"></i>
                                Publish Post
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Posts Section -->
                <div class="lg:col-span-2">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-newspaper text-2xl text-indigo-600 mr-3"></i>
                        <h2 class="text-2xl font-bold text-gray-800">Recent Posts</h2>
                        <span class="ml-3 bg-indigo-100 text-indigo-800 text-sm px-3 py-1 rounded-full">{{count($posts)}} posts</span>
                    </div>
                    
                    <!-- Debug info -->
                    <div class="mb-4 p-4 bg-yellow-100 border border-yellow-400 rounded">
                        <p><strong>Debug:</strong> Posts count: {{count($posts)}}</p>
                        <p><strong>User authenticated:</strong> {{auth()->check() ? 'Yes' : 'No'}}</p>
                        @if(auth()->check())
                            <p><strong>User ID:</strong> {{auth()->id()}}</p>
                        @endif
                    </div>
                    
                    @if($posts->count() > 0)
                        <div class="space-y-6">
                            @foreach($posts as $post)
                                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition duration-300">
                                    <div class="p-6">
                                        <div class="flex items-start justify-between mb-4">
                                            <div class="flex-1">
                                                <h3 class="text-xl font-semibold text-gray-800 mb-2">{{$post['title']}}</h3>
                                                <div class="flex items-center text-sm text-gray-500 mb-3">
                                                    <i class="fas fa-user-circle mr-2"></i>
                                                    <span>by {{$post->user->name}}</span>
                                                    <span class="mx-2">•</span>
                                                    <i class="fas fa-clock mr-1"></i>
                                                    <span>{{$post->created_at->diffForHumans()}}</span>
                                                    <span class="mx-2">•</span>
                                                    <i class="fas fa-comments mr-1"></i>
                                                    <span>{{$post->comments_count}} comments</span>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-gray-600 leading-relaxed mb-4">{{substr($post['body'], 0, 150)}}{{strlen($post['body']) > 150 ? '...' : ''}}</p>
                                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                            <div class="flex flex-wrap gap-2">
                                                <a href="/post/{{$post->id}}" 
                                                   class="bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition duration-200 flex items-center shadow-md">
                                                    <i class="fas fa-eye mr-2"></i>
                                                    View Post & Comments
                                                </a>
                                                <a href="/edit-post/{{$post->id}}" 
                                                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 flex items-center">
                                                    <i class="fas fa-edit mr-2"></i>
                                                    Edit
                                                </a>
                                                <form action="/delete-post/{{$post->id}}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="return confirm('Are you sure you want to delete this post?')"
                                                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 flex items-center">
                                                        <i class="fas fa-trash mr-2"></i>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white rounded-xl shadow-lg p-12 text-center border border-gray-200">
                            <i class="fas fa-newspaper text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-600 mb-2">No posts yet</h3>
                            <p class="text-gray-500">Create your first post to get started!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        <!-- Authentication Section -->
        <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8">
                <div class="text-center">
                    <i class="fas fa-blog text-6xl text-indigo-600 mb-4"></i>
                    <h2 class="text-3xl font-bold text-gray-900">Welcome to Blog Platform</h2>
                    <p class="mt-2 text-gray-600">Join our community and start sharing your thoughts</p>
                </div>

                <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-200">
                    <div class="mb-8">
                        <div class="flex border-b border-gray-200">
                            <button onclick="showRegister()" id="registerTab" class="flex-1 py-3 px-4 text-center font-medium text-indigo-600 border-b-2 border-indigo-600">
                                Register
                            </button>
                            <button onclick="showLogin()" id="loginTab" class="flex-1 py-3 px-4 text-center font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700">
                                Login
                            </button>
                        </div>
                    </div>

                    <!-- Register Form -->
                    <div id="registerForm">
                        <form action="/register" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                <input name="name" type="text" placeholder="Enter your full name" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                <input name="email" type="email" placeholder="Enter your email" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                <input name="password" type="password" placeholder="Create a password" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                            </div>
                            <button type="submit" class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white py-3 px-4 rounded-lg font-medium transition duration-200">
                                Create Account
                            </button>
                        </form>
                    </div>

                    <!-- Login Form -->
                    <div id="loginForm" style="display: none;">
                        <form action="/login" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                <input name="loginname" type="text" placeholder="Enter your name" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                <input name="loginpassword" type="password" placeholder="Enter your password" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                            </div>
                            <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 text-white py-3 px-4 rounded-lg font-medium transition duration-200">
                                Sign In
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endauth

    <script>
        function showRegister() {
            document.getElementById('registerForm').style.display = 'block';
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('registerTab').className = 'flex-1 py-3 px-4 text-center font-medium text-indigo-600 border-b-2 border-indigo-600';
            document.getElementById('loginTab').className = 'flex-1 py-3 px-4 text-center font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700';
        }
        
        function showLogin() {
            document.getElementById('registerForm').style.display = 'none';
            document.getElementById('loginForm').style.display = 'block';
            document.getElementById('loginTab').className = 'flex-1 py-3 px-4 text-center font-medium text-indigo-600 border-b-2 border-indigo-600';
            document.getElementById('registerTab').className = 'flex-1 py-3 px-4 text-center font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700';
        }
    </script>
</body>
</html>