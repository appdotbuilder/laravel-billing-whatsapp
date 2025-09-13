import React from 'react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { useForm } from '@inertiajs/react';
import { Head } from '@inertiajs/react';
import { type BreadcrumbItem } from '@/types';



const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Customers', href: '/customers' },
    { title: 'Add Customer', href: '/customers/create' },
];

export default function CreateCustomer() {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        whatsapp_number: '',
        address: '',
        is_active: true,
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post('/customers');
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Add Customer" />
            <div className="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
                <div>
                    <h1 className="text-3xl font-bold text-gray-900">👥 Add New Customer</h1>
                    <p className="mt-2 text-gray-600">
                        Add a new customer to your water billing system
                    </p>
                </div>

                <div className="bg-white rounded-lg shadow-sm border p-6 max-w-2xl">
                    <form onSubmit={handleSubmit} className="space-y-6">
                        <div>
                            <label htmlFor="name" className="block text-sm font-medium text-gray-700 mb-2">
                                Customer Name *
                            </label>
                            <input
                                type="text"
                                id="name"
                                value={data.name}
                                onChange={(e) => setData('name', e.target.value)}
                                className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter customer name"
                            />
                            {errors.name && (
                                <p className="mt-1 text-sm text-red-600">{errors.name}</p>
                            )}
                        </div>

                        <div>
                            <label htmlFor="whatsapp_number" className="block text-sm font-medium text-gray-700 mb-2">
                                WhatsApp Number *
                            </label>
                            <input
                                type="text"
                                id="whatsapp_number"
                                value={data.whatsapp_number}
                                onChange={(e) => setData('whatsapp_number', e.target.value)}
                                className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                placeholder="e.g., +62812345678"
                            />
                            {errors.whatsapp_number && (
                                <p className="mt-1 text-sm text-red-600">{errors.whatsapp_number}</p>
                            )}
                        </div>

                        <div>
                            <label htmlFor="address" className="block text-sm font-medium text-gray-700 mb-2">
                                Address *
                            </label>
                            <textarea
                                id="address"
                                value={data.address}
                                onChange={(e) => setData('address', e.target.value)}
                                rows={4}
                                className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter customer address"
                            />
                            {errors.address && (
                                <p className="mt-1 text-sm text-red-600">{errors.address}</p>
                            )}
                        </div>

                        <div>
                            <div className="flex items-center">
                                <input
                                    type="checkbox"
                                    id="is_active"
                                    checked={data.is_active}
                                    onChange={(e) => setData('is_active', e.target.checked as true)}
                                    className="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                />
                                <label htmlFor="is_active" className="ml-2 block text-sm text-gray-700">
                                    Customer is active
                                </label>
                            </div>
                        </div>

                        <div className="flex gap-4 pt-6">
                            <Button type="submit" disabled={processing}>
                                {processing ? '⏳ Saving...' : '💾 Save Customer'}
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
        </AppLayout>
    );
}