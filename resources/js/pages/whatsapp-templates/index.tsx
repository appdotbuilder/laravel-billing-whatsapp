import React from 'react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { router } from '@inertiajs/react';
import { Head } from '@inertiajs/react';
import { type BreadcrumbItem } from '@/types';

interface WhatsappTemplate {
    id: number;
    name: string;
    type: string;
    message: string;
    is_active: boolean;
    created_at: string;
}

interface Props {
    templates: {
        data: WhatsappTemplate[];
        links: unknown;
        meta: unknown;
    };
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'WhatsApp Templates', href: '/whatsapp-templates' },
];

export default function WhatsappTemplatesIndex({ templates }: Props) {
    const getTypeIcon = (type: string) => {
        switch (type) {
            case 'meter_reading_request':
                return '📷';
            case 'payment_reminder':
                return '💰';
            default:
                return '📱';
        }
    };

    const getTypeLabel = (type: string) => {
        switch (type) {
            case 'meter_reading_request':
                return 'Meter Reading Request';
            case 'payment_reminder':
                return 'Payment Reminder';
            default:
                return type;
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="WhatsApp Templates" />
            <div className="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
                <div className="flex justify-between items-center">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">📱 WhatsApp Templates</h1>
                        <p className="mt-2 text-gray-600">
                            Manage automated WhatsApp message templates
                        </p>
                    </div>
                    <Button onClick={() => router.get('/whatsapp-templates/create')}>
                        ➕ Add New Template
                    </Button>
                </div>

                <div className="grid gap-6">
                    {templates.data.map((template) => (
                        <div key={template.id} className="bg-white rounded-lg shadow-sm border p-6">
                            <div className="flex justify-between items-start mb-4">
                                <div className="flex items-center space-x-3">
                                    <div className="text-3xl">
                                        {getTypeIcon(template.type)}
                                    </div>
                                    <div>
                                        <h3 className="text-lg font-semibold text-gray-900">
                                            {template.name}
                                        </h3>
                                        <p className="text-sm text-gray-500">
                                            {getTypeLabel(template.type)}
                                        </p>
                                    </div>
                                </div>
                                <div className="flex items-center space-x-2">
                                    <span className={`px-2 py-1 text-xs font-medium rounded-full ${
                                        template.is_active 
                                            ? 'bg-green-100 text-green-800' 
                                            : 'bg-red-100 text-red-800'
                                    }`}>
                                        {template.is_active ? 'Active' : 'Inactive'}
                                    </span>
                                </div>
                            </div>

                            <div className="mb-4">
                                <h4 className="text-sm font-medium text-gray-700 mb-2">Message Preview:</h4>
                                <div className="bg-gray-50 p-3 rounded-lg border-l-4 border-green-400">
                                    <p className="text-sm text-gray-800 whitespace-pre-wrap">
                                        {template.message}
                                    </p>
                                </div>
                            </div>

                            <div className="flex justify-between items-center">
                                <div className="text-xs text-gray-500">
                                    Available variables: {template.type === 'meter_reading_request' 
                                        ? '{customer_name}' 
                                        : '{customer_name}, {month}, {amount}'
                                    }
                                </div>
                                <div className="flex space-x-2">
                                    <Button
                                        size="sm"
                                        variant="outline"
                                        onClick={() => router.get(`/whatsapp-templates/${template.id}`)}
                                    >
                                        👁️ View
                                    </Button>
                                    <Button
                                        size="sm"
                                        variant="outline"
                                        onClick={() => router.get(`/whatsapp-templates/${template.id}/edit`)}
                                    >
                                        ✏️ Edit
                                    </Button>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>

                {templates.data.length === 0 && (
                    <div className="bg-white rounded-lg shadow-sm border">
                        <div className="text-center py-12">
                            <div className="text-6xl mb-4">📱</div>
                            <h3 className="text-lg font-medium text-gray-900 mb-2">
                                No WhatsApp templates found
                            </h3>
                            <p className="text-gray-500 mb-4">
                                Create templates for automated meter reading requests and payment reminders.
                            </p>
                            <Button onClick={() => router.get('/whatsapp-templates/create')}>
                                ➕ Create First Template
                            </Button>
                        </div>
                    </div>
                )}

                {/* Quick Info Section */}
                <div className="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h3 className="text-lg font-semibold text-blue-900 mb-3">
                        💡 WhatsApp Integration Info
                    </h3>
                    <div className="space-y-2 text-sm text-blue-800">
                        <p><strong>📅 Scheduled Messages:</strong></p>
                        <ul className="ml-4 space-y-1">
                            <li>• 1st of each month: Meter reading requests sent automatically</li>
                            <li>• 10th of each month: Payment reminders sent for due invoices</li>
                        </ul>
                        <p className="mt-3"><strong>🔧 Setup Required:</strong></p>
                        <ul className="ml-4 space-y-1">
                            <li>• Configure Node.js Baileys service for WhatsApp integration</li>
                            <li>• Set up Web WhatsApp login in admin dashboard</li>
                            <li>• Templates support variables like {'{customer_name}'}, {'{amount}'}, {'{month}'}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}