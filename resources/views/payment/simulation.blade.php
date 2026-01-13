@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-2xl">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Virtual Payment Gate</h2>
                <p class="mt-2 text-sm text-gray-600">Simulating Third-party Payment Provider</p>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Merchant</span>
                    <span class="font-bold text-gray-800">SiBantu Platform</span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Transaction ID</span>
                    <span class="font-mono text-xs">{{ $transaction->transaction_code }}</span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Amount</span>
                    <span class="font-bold text-blue-600 text-lg">Rp
                        {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Status</span>
                    <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Pending</span>
                </div>
            </div>

            <div class="space-y-4">
                <form action="{{ route('payment.callback', $transaction->transaction_code) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-md transform transition hover:-translate-y-0.5">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-green-500 group-hover:text-green-400"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                        ✅ Simulate SUCCESS Payment
                    </button>
                </form>

                <a href="{{ route('campaigns.show', $transaction->campaign->slug) }}"
                    class="block w-full text-center text-sm text-gray-500 hover:text-gray-900">Cancel Payment</a>
            </div>
        </div>
    </div>
@endsection