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
    is_active: boolean;
}

interface Invoice {
    id: number;
    invoice_number: string;
    amount: number;
    status: string;
    customer: {
        name: string;
    };
}

interface PaymentStat {
    status: string;
    count: number;
    total_amount: number;
}

interface Props {
    stats: {
        totalCustomers: number;
        totalInvoicesThisMonth: number;
        totalRevenueThisMonth: number;
        unpaidInvoices: number;
    };
    recentCustomers: Customer[];
    recentInvoices: Invoice[];
    paymentStats: PaymentStat[];
    currentMonth: number;
    currentYear: number;
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard({ 
    stats, 
    recentCustomers, 
    recentInvoices, 
    paymentStats, 
    currentMonth, 
    currentYear 
}: Props) {
    const formatCurrency = (amount: number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
        }).format(amount);
    };

    const formatMonth = (month: number) => {
        const months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        return months[month - 1];
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
                <div>
                    <h1 className="text-3xl font-bold text-gray-900">💧 Water Billing Dashboard</h1>
                    <p className="mt-2 text-gray-600">
                        Overview of your water billing system for {formatMonth(currentMonth)} {currentYear}
                    </p>
                </div>

                {/* Stats Cards */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div className="bg-white p-6 rounded-lg shadow-sm border">
                        <div className="flex items-center">
                            <div className="p-2 bg-blue-100 rounded-lg">
                                <span className="text-2xl">👥</span>
                            </div>
                            <div className="ml-4">
                                <p className="text-sm text-gray-600">Total Customers</p>
                                <p className="text-2xl font-bold text-gray-900">{stats.totalCustomers}</p>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white p-6 rounded-lg shadow-sm border">
                        <div className="flex items-center">
                            <div className="p-2 bg-green-100 rounded-lg">
                                <span className="text-2xl">🧾</span>
                            </div>
                            <div className="ml-4">
                                <p className="text-sm text-gray-600">Invoices This Month</p>
                                <p className="text-2xl font-bold text-gray-900">{stats.totalInvoicesThisMonth}</p>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white p-6 rounded-lg shadow-sm border">
                        <div className="flex items-center">
                            <div className="p-2 bg-yellow-100 rounded-lg">
                                <span className="text-2xl">💰</span>
                            </div>
                            <div className="ml-4">
                                <p className="text-sm text-gray-600">Revenue This Month</p>
                                <p className="text-xl font-bold text-gray-900">{formatCurrency(stats.totalRevenueThisMonth)}</p>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white p-6 rounded-lg shadow-sm border">
                        <div className="flex items-center">
                            <div className="p-2 bg-red-100 rounded-lg">
                                <span className="text-2xl">⚠️</span>
                            </div>
                            <div className="ml-4">
                                <p className="text-sm text-gray-600">Unpaid Invoices</p>
                                <p className="text-2xl font-bold text-red-600">{stats.unpaidInvoices}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Quick Actions */}
                <div>
                    <h2 className="text-xl font-semibold mb-4">Quick Actions</h2>
                    <div className="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
                        <Button 
                            onClick={() => router.get('/customers/create')}
                            className="flex flex-col items-center p-4 h-auto"
                        >
                            <span className="text-2xl mb-2">👥</span>
                            <span className="text-sm">Add Customer</span>
                        </Button>
                        <Button 
                            onClick={() => router.get('/usages/create')}
                            className="flex flex-col items-center p-4 h-auto"
                        >
                            <span className="text-2xl mb-2">📊</span>
                            <span className="text-sm">Record Usage</span>
                        </Button>
                        <Button 
                            onClick={() => router.get('/billing-rates/create')}
                            className="flex flex-col items-center p-4 h-auto"
                        >
                            <span className="text-2xl mb-2">💧</span>
                            <span className="text-sm">Set Rate</span>
                        </Button>
                        <Button 
                            onClick={() => router.get('/invoices')}
                            className="flex flex-col items-center p-4 h-auto"
                        >
                            <span className="text-2xl mb-2">🧾</span>
                            <span className="text-sm">View Invoices</span>
                        </Button>
                        <Button 
                            onClick={() => router.get('/whatsapp-templates')}
                            className="flex flex-col items-center p-4 h-auto"
                        >
                            <span className="text-2xl mb-2">📱</span>
                            <span className="text-sm">WhatsApp</span>
                        </Button>
                        <Button 
                            onClick={() => router.get('/customers')}
                            className="flex flex-col items-center p-4 h-auto"
                        >
                            <span className="text-2xl mb-2">👀</span>
                            <span className="text-sm">All Customers</span>
                        </Button>
                    </div>
                </div>

                {/* Recent Activity */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {/* Recent Customers */}
                    <div className="bg-white p-6 rounded-lg shadow-sm border">
                        <div className="flex justify-between items-center mb-4">
                            <h3 className="text-lg font-semibold">Recent Customers</h3>
                            <Button 
                                variant="outline" 
                                size="sm"
                                onClick={() => router.get('/customers')}
                            >
                                View All
                            </Button>
                        </div>
                        <div className="space-y-3">
                            {recentCustomers.map((customer) => (
                                <div key={customer.id} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p className="font-medium">{customer.name}</p>
                                        <p className="text-sm text-gray-600">{customer.whatsapp_number}</p>
                                    </div>
                                    <div className="text-right">
                                        <span className={`px-2 py-1 rounded text-xs ${
                                            customer.is_active 
                                                ? 'bg-green-100 text-green-800' 
                                                : 'bg-red-100 text-red-800'
                                        }`}>
                                            {customer.is_active ? 'Active' : 'Inactive'}
                                        </span>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>

                    {/* Recent Invoices */}
                    <div className="bg-white p-6 rounded-lg shadow-sm border">
                        <div className="flex justify-between items-center mb-4">
                            <h3 className="text-lg font-semibold">Recent Invoices</h3>
                            <Button 
                                variant="outline" 
                                size="sm"
                                onClick={() => router.get('/invoices')}
                            >
                                View All
                            </Button>
                        </div>
                        <div className="space-y-3">
                            {recentInvoices.map((invoice) => (
                                <div key={invoice.id} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p className="font-medium">{invoice.invoice_number}</p>
                                        <p className="text-sm text-gray-600">{invoice.customer.name}</p>
                                    </div>
                                    <div className="text-right">
                                        <p className="font-medium">{formatCurrency(invoice.amount)}</p>
                                        <span className={`px-2 py-1 rounded text-xs ${
                                            invoice.status === 'paid' 
                                                ? 'bg-green-100 text-green-800' 
                                                : invoice.status === 'overdue'
                                                ? 'bg-red-100 text-red-800'
                                                : 'bg-yellow-100 text-yellow-800'
                                        }`}>
                                            {invoice.status}
                                        </span>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>

                {/* Payment Status Summary */}
                {paymentStats.length > 0 && (
                    <div className="bg-white p-6 rounded-lg shadow-sm border">
                        <h3 className="text-lg font-semibold mb-4">Payment Status This Month</h3>
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                            {paymentStats.map((stat) => (
                                <div key={stat.status} className="text-center p-4 border rounded-lg">
                                    <p className="text-2xl font-bold text-gray-900">{stat.count}</p>
                                    <p className="text-sm text-gray-600 capitalize">{stat.status} Invoices</p>
                                    <p className="text-lg font-medium text-gray-700">
                                        {formatCurrency(stat.total_amount)}
                                    </p>
                                </div>
                            ))}
                        </div>
                    </div>
                )}
            </div>
        </AppLayout>
    );
}