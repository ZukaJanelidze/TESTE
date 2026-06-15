<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Admin Panel
            </h2>
            <span class="rounded bg-indigo-100 px-3 py-1 text-sm font-medium text-indigo-700">
                {{ Auth::user()->name }}
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="grid gap-4 sm:grid-cols-3">
                <div class="rounded bg-white p-5 shadow dark:bg-gray-800">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Users</div>
                    <div class="mt-2 text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $userCount }}</div>
                </div>
                <div class="rounded bg-white p-5 shadow dark:bg-gray-800">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Posts</div>
                    <div class="mt-2 text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $postCount }}</div>
                </div>
                <div class="rounded bg-white p-5 shadow dark:bg-gray-800">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Admins</div>
                    <div class="mt-2 text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $adminCount }}</div>
                </div>
            </div>

            <section class="rounded bg-white shadow dark:bg-gray-800">
                <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Users</h3>
                </div>

                <form method="GET" action="{{ route('admin.index') }}" class="grid gap-3 border-b border-gray-200 px-5 py-4 dark:border-gray-700 sm:grid-cols-[1fr_auto_auto]">
                    <input
                        type="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Search name or email"
                        class="rounded border-gray-300 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                    >

                    <select name="role" class="rounded border-gray-300 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                        <option value="">All roles</option>
                        <option value="user" @selected($selectedRole === 'user')>Users</option>
                        <option value="manager" @selected($selectedRole === 'manager')>Managers</option>
                        <option value="admin" @selected($selectedRole === 'admin')>Admins</option>
                    </select>

                    <div class="flex gap-2">
                        <button type="submit" class="rounded bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700 dark:bg-gray-100 dark:text-gray-900 dark:hover:bg-white">
                            Filter
                        </button>
                        @if ($search !== '' || $selectedRole !== '')
                            <a href="{{ route('admin.index') }}" class="rounded border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-900">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>

               

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Name</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Email</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Role</th>
                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="px-5 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</td>
                                    <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $user->email }}</td>
                                    <td class="px-5 py-4">
                                        <form method="POST" action="{{ route('admin.users.role', $user) }}">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role" onchange="this.form.submit()" class="rounded border-gray-300 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                                <option value="user" @selected($user->role === 'user')>User</option>
                                                <option value="manager" @selected($user->role === 'manager')>Manager</option>
                                                <option value="admin" @selected($user->role === 'admin')>Admin</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        @if (! $user->is(Auth::user()))
                                            <div class="inline-flex flex-wrap items-center justify-end gap-2">
                                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user?')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">
                                                        Delete
                                                    </button>
                                                </form>

                                                <form method="POST" action="{{ route('admin.users.ban', $user) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-sm font-medium text-yellow-600 hover:text-yellow-800">
                                                        Ban 7 Days
                                                    </button>
                                                </form>

                                                <form method="POST" action="{{ route('admin.users.unban', $user) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-sm font-medium text-green-600 hover:text-green-800">
                                                        Unban
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-400">Current user</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                                        No users match your filters.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </section>

            <section class="rounded bg-white shadow dark:bg-gray-800">
                <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Posts</h3>
                </div>

                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($posts as $post)
                        <div class="flex flex-col gap-3 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <div class="font-medium text-gray-900 dark:text-gray-100">{{ $post->title }}</div>
                                <div class="mt-1 line-clamp-2 text-sm text-gray-500 dark:text-gray-400">{{ $post->body }}</div>
                            </div>
                            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Delete this post?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="px-5 py-6 text-sm text-gray-500 dark:text-gray-400">No posts yet.</div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
