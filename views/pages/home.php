<?php
loadPartial('head');
loadPartial('nav');
?>



<!-- Hero -->
<main>
    <section class="bg-blue-600 text-white">
        <div class="mx-auto max-w-7xl px-4 py-20 text-center">
            <h2 class="text-3xl font-bold sm:text-4xl">
                Turn chores into rewards
            </h2>

            <p class="mt-4 max-w-2xl mx-auto text-lg text-blue-100">
                Earn It helps families manage tasks, track progress, and turn effort into rewards that actually matter.
            </p>

            <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:justify-center">
                <a href="/auth/register?type=parent"
                    class="rounded-lg bg-white px-6 py-3 font-semibold text-blue-600 hover:bg-gray-100">
                    I am a parent
                </a>

                <a href="/auth/register?type=child"
                    class="rounded-lg border border-white px-6 py-3 font-semibold hover:bg-blue-700">
                    I am a child
                </a>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4">
            <h3 class="text-center text-2xl font-bold">
                How it works
            </h3>

            <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <h4 class="text-lg font-semibold">Assign tasks</h4>
                    <p class="mt-2 text-gray-600">
                        Parents create tasks for their children with clear goals and points.
                    </p>
                </div>

                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <h4 class="text-lg font-semibold">Complete and earn</h4>
                    <p class="mt-2 text-gray-600">
                        Children complete tasks and earn points for their effort.
                    </p>
                </div>

                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <h4 class="text-lg font-semibold">Save for rewards</h4>
                    <p class="mt-2 text-gray-600">
                        Points go towards a wish list so motivation stays high.
                    </p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php loadPartial('footer'); ?>