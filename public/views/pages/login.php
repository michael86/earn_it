<?php
loadPartial('head');
loadPartial('nav');
?>

<main class="py-16">
    <div class="mx-auto max-w-md px-4">
        <div class="rounded-xl bg-white p-8 shadow-sm">
            <h1 class="text-2xl font-bold text-gray-900">
                Login
            </h1>

            <p class="mt-2 text-sm text-gray-600">
                Welcome back. Sign in to view your dashboard.
            </p>

            <form class="mt-8 space-y-5" method="post" action="/login">
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Email address
                    </label>
                    <input
                        type="email"
                        name="email"
                        autocomplete="email"
                        required
                        class="mt-1 w-full rounded-md border border-gray-300 px-4 py-2 focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600"
                        placeholder="you@example.com">
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label class="block text-sm font-medium text-gray-700">
                            Password
                        </label>

                        <a href="/forgot-password" class="text-sm font-medium text-blue-600 hover:text-blue-700">
                            Forgot password
                        </a>
                    </div>

                    <input
                        type="password"
                        name="password"
                        autocomplete="current-password"
                        required
                        class="mt-1 w-full rounded-md border border-gray-300 px-4 py-2 focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600"
                        placeholder="Your password">
                </div>

                <div class="flex items-center gap-2">
                    <input
                        id="remember"
                        name="remember"
                        type="checkbox"
                        class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600">
                    <label for="remember" class="text-sm text-gray-600">
                        Remember me
                    </label>
                </div>

                <button
                    type="submit"
                    class="w-full rounded-md bg-blue-600 px-4 py-2.5 font-semibold text-white hover:bg-blue-700">
                    Sign in
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600">
                No account yet?
                <a href="/register" class="font-semibold text-blue-600 hover:text-blue-700">
                    Create one
                </a>
            </p>
        </div>
    </div>
</main>

<?php loadPartial('footer'); ?>