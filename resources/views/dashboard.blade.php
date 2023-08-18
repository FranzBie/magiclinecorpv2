@section('title')
    Home
@endsection

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Magic Line') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="flex flex-wrap">

                @foreach ($companies as $company)
                <div class="w-full sm:w-1/5 p-4">

                    <a href="#" class="block text-center relative overflow-hidden group">
                        <!-- Content for the first square -->
                        <div class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800 rounded-md">
                            <div class="relative">
                                <div class="absolute left-0 top-5 transform -translate-x-1/2 -translate-y-1/2 ml-7 w-20 h-20 rounded-md flex justify-center items-center">
                                    <div class="bg-white w-full h-full rounded-md flex justify-center items-center">
                                        <img src="{{ asset('storage/' . $company->images) }}" alt="Company Image" class="w-16 h-16 object-contain">
                                    </div>
                                </div>

                                <!-- Content container -->
                                <div class="p-6 items-end flex justify-end">
                                    <div class="text-sm text-gray-500">
                                        <div class="text-right">
                                            <div class="text-2xl font-semibold text-white-800">
                                                <span class="text-5xl text-800 text-white">
                                                    {{ $mannequins->where('company', $company->name)->count() }}
                                                </span>
                                            </div>
                                            <div class="text-xs text-white-500">
                                                <p class="text-white">{{ $company->name }}'s Products</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pseudo-element for hover effect -->
                        <div class="absolute left-0 bottom-0 h-0 w-full bg-gradient-to-t from-gray-400 to-transparent transition-all duration-300 ease-in-out group-hover:h-full"></div>
                    </a>
                </div>
                @endforeach

            </div>
        </div>
    </div>


</x-app-layout>
