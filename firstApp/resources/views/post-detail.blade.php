<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$post->title}} - Blog Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
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
                    @auth
                        <form action="/logout" method="POST" class="inline">
                            @csrf
                            <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                Logout
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Post Content -->
        <article class="bg-white rounded-xl shadow-lg p-8 border border-gray-200 mb-8">
            <header class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{$post->title}}</h1>
                <div class="flex items-center text-gray-600 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-user-circle text-2xl mr-3"></i>
                        <div>
                            <p class="font-medium">{{$post->user->name}}</p>
                            <p class="text-sm text-gray-500">
                                <i class="fas fa-clock mr-1"></i>
                                {{$post->created_at->format('F j, Y')}} • {{$post->created_at->diffForHumans()}}
                            </p>
                        </div>
                    </div>
                </div>
                
                @auth
                    @if(auth()->id() === $post->user_id)
                        <div class="flex space-x-3 mb-6">
                            <a href="/edit-post/{{$post->id}}" 
                               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 flex items-center">
                                <i class="fas fa-edit mr-2"></i>
                                Edit Post
                            </a>
                            <form action="/delete-post/{{$post->id}}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure you want to delete this post?')"
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 flex items-center">
                                    <i class="fas fa-trash mr-2"></i>
                                    Delete Post
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </header>

            <div class="prose prose-lg max-w-none">
                <div class="text-gray-700 leading-relaxed text-lg whitespace-pre-line">{{$post->body}}</div>
            </div>
        </article>

        <!-- Comments Section -->
        <section id="comments" class="bg-white rounded-xl shadow-lg border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-comments mr-3 text-indigo-600"></i>
                        Comments
                        <span class="ml-3 bg-indigo-100 text-indigo-800 text-sm px-3 py-1 rounded-full">{{$comments->count()}}</span>
                    </h2>
                </div>
            </div>

            <!-- Add Comment Form -->
            @auth
                <div class="p-6 border-b border-gray-200 bg-gray-50">
                    <form action="/post/{{$post->id}}/comment" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Add a comment</label>
                            <textarea name="content" 
                                      rows="4" 
                                      placeholder="Share your thoughts about this post..."
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 resize-none"
                                      required></textarea>
                        </div>
                        <button type="submit" 
                                class="bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200 flex items-center">
                            <i class="fas fa-comment mr-2"></i>
                            Post Comment
                        </button>
                    </form>
                </div>
            @else
                <div class="p-6 border-b border-gray-200 bg-gray-50 text-center">
                    <p class="text-gray-600 mb-4">You must be logged in to comment on this post.</p>
                    <a href="/" class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                        Go to Login
                    </a>
                </div>
            @endauth

            <!-- Comments List -->
            <div class="divide-y divide-gray-200">
                @if($comments->count() > 0)
                    @foreach($comments as $comment)
                        <div class="p-6 hover:bg-gray-50 transition duration-150" id="comment-{{$comment->id}}">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center">
                                        <span class="text-white font-medium text-sm">
                                            {{strtoupper(substr($comment->user->name, 0, 1))}}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="text-sm font-medium text-gray-900">{{$comment->user->name}}</h4>
                                        <div class="flex items-center space-x-2">
                                            <time class="text-sm text-gray-500">
                                                {{$comment->created_at->diffForHumans()}}
                                                @if($comment->updated_at != $comment->created_at)
                                                    <span class="text-xs text-gray-400">(edited)</span>
                                                @endif
                                            </time>
                                            @auth
                                                @if(auth()->id() === $comment->user_id)
                                                    <button onclick="toggleEditComment({{$comment->id}})" 
                                                            class="text-blue-500 hover:text-blue-700 text-xs font-medium">
                                                        <i class="fas fa-edit mr-1"></i>Edit
                                                    </button>
                                                    <form action="/comment/{{$comment->id}}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button onclick="return confirm('Are you sure you want to delete this comment?')"
                                                                class="text-red-500 hover:text-red-700 text-xs font-medium">
                                                            <i class="fas fa-trash mr-1"></i>Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            @endauth
                                        </div>
                                    </div>
                                    
                                    <!-- Display Comment -->
                                    <div id="comment-display-{{$comment->id}}">
                                        <p class="text-gray-700 leading-relaxed">{{$comment->content}}</p>
                                    </div>
                                    
                                    <!-- Edit Comment Form (Hidden by default) -->
                                    <div id="comment-edit-{{$comment->id}}" style="display: none;">
                                        <form action="/comment/{{$comment->id}}" method="POST" class="mt-2">
                                            @csrf
                                            @method('PUT')
                                            <textarea name="content" 
                                                      rows="3" 
                                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm"
                                                      required>{{$comment->content}}</textarea>
                                            <div class="mt-2 flex space-x-2">
                                                <button type="submit" 
                                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-medium">
                                                    <i class="fas fa-save mr-1"></i>Update
                                                </button>
                                                <button type="button" 
                                                        onclick="toggleEditComment({{$comment->id}})"
                                                        class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded text-xs font-medium">
                                                    Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="p-12 text-center">
                        <i class="fas fa-comment-alt text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">No comments yet</h3>
                        <p class="text-gray-500">Be the first to share your thoughts about this post!</p>
                    </div>
                @endif
            </div>
        </section>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div id="success-message" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{session('success')}}
            </div>
        </div>
        <script>
            setTimeout(() => {
                const successMsg = document.getElementById('success-message');
                if (successMsg) {
                    successMsg.style.opacity = '0';
                    setTimeout(() => successMsg.remove(), 300);
                }
            }, 3000);
        </script>
    @endif

    @if(session('error'))
        <div id="error-message" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{session('error')}}
            </div>
        </div>
        <script>
            setTimeout(() => {
                const errorMsg = document.getElementById('error-message');
                if (errorMsg) {
                    errorMsg.style.opacity = '0';
                    setTimeout(() => errorMsg.remove(), 300);
                }
            }, 3000);
        </script>
    @endif

    <script>
        function toggleEditComment(commentId) {
            const displayDiv = document.getElementById('comment-display-' + commentId);
            const editDiv = document.getElementById('comment-edit-' + commentId);
            
            if (editDiv.style.display === 'none') {
                displayDiv.style.display = 'none';
                editDiv.style.display = 'block';
            } else {
                displayDiv.style.display = 'block';
                editDiv.style.display = 'none';
            }
        }

        // Auto-resize textareas
        document.addEventListener('DOMContentLoaded', function() {
            const textareas = document.querySelectorAll('textarea');
            textareas.forEach(textarea => {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = this.scrollHeight + 'px';
                });
            });
        });
    </script>
</body>
</html>
