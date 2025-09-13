import React from 'react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { router } from '@inertiajs/react';
import { Head } from '@inertiajs/react';
import { type BreadcrumbItem } from '@/types';

interface Customer {
    id: number;
    name: string;
    whatsapp_number: string;
    address: string;
    is_active: boolean;
    created_at: string;
}

interface Props {
    customers: {
        data: Customer[];
        links: unknown;
        meta: unknown;
    };
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Customers', href: '/customers' },
];

export default function CustomersIndex({ customers }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Customers" />
            <div className="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
                <div className="flex justify-between items-center">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">👥 Customers</h1>
                        <p className="mt-2 text-gray-600">
                            Manage your water utility customers
                        </p>
                    </div>
                    <Button onClick={() => router.get('/customers/create')}>
                        ➕ Add New Customer
                    </Button>
                </div>

                <div className="bg-white rounded-lg shadow-sm border overflow-hidden">
                    <div className="px-6 py-4 border-b">
                        <h2 className="text-lg font-semibold">All Customers</h2>
                    </div>
                    
                    <div className="overflow-x-auto">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Customer
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        WhatsApp
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Address
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody className="bg-white divide-y divide-gray-200">
                                {customers.data.map((customer) => (
                                    <tr key={customer.id} className="hover:bg-gray-50">
                                        <td className="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div className="text-sm font-medium text-gray-900">
                                                    {customer.name}
                                                </div>
                                                <div className="text-sm text-gray-500">
                                                    ID: {customer.id}
                                                </div>
                                            </div>
                                        </td>
                                        <td className="px-6 py-4 whitespace-nowrap">
                                            <div className="text-sm text-gray-900">
                                                {customer.whatsapp_number}
                                            </div>
                                        </td>
                                        <td className="px-6 py-4">
                                            <div className="text-sm text-gray-900 max-w-xs truncate">
                                                {customer.address}
                                            </div>
                                        </td>
                                        <td className="px-6 py-4 whitespace-nowrap">
                                            <span className={`px-2 py-1 text-xs font-medium rounded-full ${
                                                customer.is_active 
                                                    ? 'bg-green-100 text-green-800' 
                                                    : 'bg-red-100 text-red-800'
                                            }`}>
                                                {customer.is_active ? 'Active' : 'Inactive'}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div className="flex space-x-2">
                                                <Button
                                                    size="sm"
                                                    variant="outline"
                                                    onClick={() => router.get(`/customers/${customer.id}`)}
                                                >
                                                    👁️ View
                                                </Button>
                                                <Button
                                                    size="sm"
                                                    variant="outline"
                                                    onClick={() => router.get(`/customers/${customer.id}/edit`)}
                                                >
                                                    ✏️ Edit
                                                </Button>
                                            </div>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>

                    {customers.data.length === 0 && (
                        <div className="text-center py-12">
                            <div className="text-6xl mb-4">👥</div>
                            <h3 className="text-lg font-medium text-gray-900 mb-2">
                                No customers found
                            </h3>
                            <p className="text-gray-500 mb-4">
                                Get started by adding your first customer.
                            </p>
                            <Button onClick={() => router.get('/customers/create')}>
                                ➕ Add First Customer
                            </Button>
                        </div>
                    )}
                </div>
            </div>
        </AppLayout>
    );
}