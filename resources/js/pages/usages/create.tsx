import React from 'react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { useForm, router } from '@inertiajs/react';
import { Head } from '@inertiajs/react';
import { type BreadcrumbItem } from '@/types';

interface Customer {
    id: number;
    name: string;
    whatsapp_number: string;
}

interface BillingRate {
    price_per_cubic_meter: number;
}



interface Props {
    customers: Customer[];
    currentMonth: number;
    currentYear: number;
    currentRate?: BillingRate;
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Usage Records', href: '/usages' },
    { title: 'Record Usage', href: '/usages/create' },
];

export default function CreateUsage({ customers, currentMonth, currentYear, currentRate }: Props) {
    const { data, setData, post, processing, errors } = useForm({
        customer_id: 0,
        cubic_meters: '',
        month: currentMonth,
        year: currentYear,
    });

    const formatCurrency = (amount: number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
        }).format(amount);
    };

    const calculateTotal = () => {
        if (currentRate && data.cubic_meters) {
            const usage = parseFloat(data.cubic_meters);
            return usage * currentRate.price_per_cubic_meter;
        }
        return 0;
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post('/usages');
    };

    const monthNames = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Record Usage" />
            <div className="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
                <div>
                    <h1 className="text-3xl font-bold text-gray-900">📊 Record Water Usage</h1>
                    <p className="mt-2 text-gray-600">
                        Input monthly cubic meter usage for automatic billing calculation
                    </p>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {/* Form */}
                    <div className="lg:col-span-2">
                        <div className="bg-white rounded-lg shadow-sm border p-6">
                            <form onSubmit={handleSubmit} className="space-y-6">
                                <div>
                                    <label htmlFor="customer_id" className="block text-sm font-medium text-gray-700 mb-2">
                                        Select Customer *
                                    </label>
                                    <select
                                        id="customer_id"
                                        value={data.customer_id}
                                        onChange={(e) => setData('customer_id', parseInt(e.target.value))}
                                        className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    >
                                        <option value="">Choose a customer...</option>
                                        {customers.map((customer) => (
                                            <option key={customer.id} value={customer.id}>
                                                {customer.name} - {customer.whatsapp_number}
                                            </option>
                                        ))}
                                    </select>
                                    {errors.customer_id && (
                                        <p className="mt-1 text-sm text-red-600">{errors.customer_id}</p>
                                    )}
                                </div>

                                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label htmlFor="month" className="block text-sm font-medium text-gray-700 mb-2">
                                            Month *
                                        </label>
                                        <select
                                            id="month"
                                            value={data.month}
                                            onChange={(e) => setData('month', parseInt(e.target.value))}
                                            className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        >
                                            {monthNames.map((month, index) => (
                                                <option key={index + 1} value={index + 1}>
                                                    {month}
                                                </option>
                                            ))}
                                        </select>
                                    </div>

                                    <div>
                                        <label htmlFor="year" className="block text-sm font-medium text-gray-700 mb-2">
                                            Year *
                                        </label>
                                        <input
                                            type="number"
                                            id="year"
                                            value={data.year}
                                            onChange={(e) => setData('year', parseInt(e.target.value))}
                                            className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                            min="2020"
                                            max="2030"
                                        />
                                    </div>

                                    <div>
                                        <label htmlFor="cubic_meters" className="block text-sm font-medium text-gray-700 mb-2">
                                            Usage (m³) *
                                        </label>
                                        <input
                                            type="number"
                                            id="cubic_meters"
                                            value={data.cubic_meters}
                                            onChange={(e) => setData('cubic_meters', e.target.value)}
                                            className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="0.00"
                                            step="0.01"
                                            min="0"
                                        />
                                        {errors.cubic_meters && (
                                            <p className="mt-1 text-sm text-red-600">{errors.cubic_meters}</p>
                                        )}
                                    </div>
                                </div>

                                <div className="flex gap-4 pt-6">
                                    <Button type="submit" disabled={processing}>
                                        {processing ? '⏳ Recording...' : '💾 Record Usage & Generate Invoice'}
                                    </Button>
                                    <Button 
                                        type="button" 
                                        variant="outline"
                                        onClick={() => window.history.back()}
                                    >
                                        ❌ Cancel
                                    </Button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {/* Calculation Summary */}
                    <div>
                        <div className="bg-white rounded-lg shadow-sm border p-6">
                            <h3 className="text-lg font-semibold text-gray-900 mb-4">
                                💰 Billing Calculation
                            </h3>
                            
                            {currentRate ? (
                                <div className="space-y-4">
                                    <div className="flex justify-between">
                                        <span className="text-gray-600">Current Rate:</span>
                                        <span className="font-medium">
                                            {formatCurrency(currentRate.price_per_cubic_meter)}/m³
                                        </span>
                                    </div>
                                    
                                    <div className="flex justify-between">
                                        <span className="text-gray-600">Usage:</span>
                                        <span className="font-medium">
                                            {data.cubic_meters || '0.00'} m³
                                        </span>
                                    </div>
                                    
                                    <hr />
                                    
                                    <div className="flex justify-between text-lg font-bold text-green-600">
                                        <span>Total Amount:</span>
                                        <span>{formatCurrency(calculateTotal())}</span>
                                    </div>
                                    
                                    <div className="text-xs text-gray-500 mt-2">
                                        * Invoice will be automatically generated with due date on the 10th
                                    </div>
                                </div>
                            ) : (
                                <div className="text-center text-gray-500">
                                    <div className="text-3xl mb-2">⚠️</div>
                                    <p className="text-sm">
                                        No billing rate set for {monthNames[currentMonth - 1]} {currentYear}
                                    </p>
                                    <Button
                                        size="sm"
                                        className="mt-3"
                                        onClick={() => router.get('/billing-rates/create')}
                                    >
                                        💧 Set Billing Rate
                                    </Button>
                                </div>
                            )}
                        </div>
                        
                        {/* Quick Info */}
                        <div className="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h4 className="text-sm font-semibold text-blue-900 mb-2">
                                📋 What happens next?
                            </h4>
                            <ul className="text-xs text-blue-800 space-y-1">
                                <li>✅ Usage recorded in system</li>
                                <li>✅ Invoice automatically generated</li>
                                <li>✅ Due date set to 10th of month</li>
                                <li>📱 WhatsApp reminder on due date</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}