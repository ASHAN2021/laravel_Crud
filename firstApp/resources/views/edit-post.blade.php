<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Post - Blog Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <!-- Navigation Header -->
    <nav class="bg-white shadow-lg border-b-4 border-indigo-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <i class="fas fa-blog text-2xl text-indigo-600 mr-3"></i>
                    <h1 class="text-xl font-bold text-gray-800">My Blog Platform</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
            <div class="flex items-center mb-8">
                <i class="fas fa-edit text-3xl text-indigo-600 mr-4"></i>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Edit Post</h2>
                    <p class="text-gray-600">Update your post content below</p>
                </div>
            </div>

            <form action="/edit-post/{{$post->id}}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Post Title</label>
                    <input type="text" 
                           name="title" 
                           value="{{$post->title}}" 
                           placeholder="Enter your post title..."
                           class="w-full px-4 py-4 text-lg border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Content</label>
                    <textarea name="body" 
                              rows="12" 
                              placeholder="Write your post content here..."
                              class="w-full px-4 py-4 text-lg border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 resize-none"
                              required>{{$post->body}}</textarea>
                </div>

                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="/" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition duration-200 flex items-center">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white px-8 py-3 rounded-lg font-medium transition duration-200 flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Update Post
                    </button>
                </div>
            </form>
        </div>

        <!-- Post Preview Card -->
        <div class="mt-8 bg-white rounded-xl shadow-lg p-6 border border-gray-200">
            <div class="flex items-center mb-4">
                <i class="fas fa-eye text-xl text-gray-600 mr-3"></i>
                <h3 class="text-lg font-semibold text-gray-800">Current Post Preview</h3>
            </div>
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <h4 class="text-xl font-semibold text-gray-800 mb-3">{{$post->title}}</h4>
                <div class="flex items-center text-sm text-gray-500 mb-4">
                    <i class="fas fa-user-circle mr-2"></i>
                    <span>by {{$post->user->name}}</span>
                    <span class="mx-2">•</span>
                    <i class="fas fa-clock mr-1"></i>
                    <span>{{$post->created_at->diffForHumans()}}</span>
                </div>
                <p class="text-gray-600 leading-relaxed">{{$post->body}}</p>
            </div>
        </div>
    </div>
</body>
</html>