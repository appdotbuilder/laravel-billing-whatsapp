import React from 'react';
import { Button } from '@/components/ui/button';
import { router } from '@inertiajs/react';

export default function Welcome() {
    const features = [
        {
            icon: '👥',
            title: 'Customer Management',
            description: 'Manage customer details, WhatsApp numbers, and addresses in one centralized system.',
        },
        {
            icon: '💧',
            title: 'Usage Tracking',
            description: 'Input monthly cubic meter usage and automatically calculate bills based on current rates.',
        },
        {
            icon: '🧾',
            title: 'Invoice Generation',
            description: 'Automatically generate unique monthly invoices with PDF download capabilities.',
        },
        {
            icon: '📱',
            title: 'WhatsApp Integration',
            description: 'Send automated meter reading requests and payment reminders via WhatsApp.',
        },
        {
            icon: '💰',
            title: 'Payment Tracking',
            description: 'Track payment status with fixed due dates on the 10th of every month.',
        },
        {
            icon: '📊',
            title: 'Admin Dashboard',
            description: 'Comprehensive dashboard with usage analytics and payment status overview.',
        },
    ];

    const handleGetStarted = () => {
        router.get('/login');
    };

    const handleViewDemo = () => {
        router.get('/dashboard');
    };

    return (
        <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
            {/* Header */}
            <nav className="container mx-auto px-6 py-4">
                <div className="flex justify-between items-center">
                    <div className="flex items-center space-x-2">
                        <div className="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <span className="text-white font-bold text-lg">💧</span>
                        </div>
                        <span className="text-xl font-bold text-gray-900">AquaBill Pro</span>
                    </div>
                    <div className="hidden md:flex items-center space-x-4">
                        <Button variant="ghost" onClick={() => router.get('/login')}>
                            Login
                        </Button>
                        <Button onClick={() => router.get('/register')}>
                            Get Started
                        </Button>
                    </div>
                </div>
            </nav>

            {/* Hero Section */}
            <section className="container mx-auto px-6 py-16">
                <div className="text-center max-w-4xl mx-auto">
                    <h1 className="text-5xl md:text-6xl font-bold text-gray-900 mb-6">
                        💧 Complete Water Billing
                        <span className="text-blue-600"> Management System</span>
                    </h1>
                    <p className="text-xl text-gray-600 mb-8 leading-relaxed">
                        Streamline your water utility billing with automated invoicing, WhatsApp notifications,
                        and comprehensive customer management. Built for efficiency and reliability.
                    </p>
                    <div className="flex flex-col sm:flex-row gap-4 justify-center">
                        <Button size="lg" onClick={handleGetStarted} className="text-lg px-8 py-3">
                            🚀 Start Managing Bills
                        </Button>
                        <Button 
                            size="lg" 
                            variant="outline" 
                            onClick={handleViewDemo}
                            className="text-lg px-8 py-3"
                        >
                            📊 View Dashboard Demo
                        </Button>
                    </div>
                </div>
            </section>

            {/* Features Grid */}
            <section className="container mx-auto px-6 py-16">
                <div className="text-center mb-12">
                    <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Everything You Need to Manage Water Billing
                    </h2>
                    <p className="text-lg text-gray-600">
                        From customer management to automated WhatsApp notifications
                    </p>
                </div>
                
                <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    {features.map((feature, index) => (
                        <div 
                            key={index}
                            className="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300"
                        >
                            <div className="text-4xl mb-4">{feature.icon}</div>
                            <h3 className="text-xl font-semibold text-gray-900 mb-2">
                                {feature.title}
                            </h3>
                            <p className="text-gray-600">
                                {feature.description}
                            </p>
                        </div>
                    ))}
                </div>
            </section>

            {/* Process Flow */}
            <section className="bg-white py-16">
                <div className="container mx-auto px-6">
                    <div className="text-center mb-12">
                        <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                            How It Works
                        </h2>
                        <p className="text-lg text-gray-600">
                            Simple 4-step process to manage your water billing
                        </p>
                    </div>

                    <div className="grid md:grid-cols-4 gap-8">
                        <div className="text-center">
                            <div className="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span className="text-2xl">👥</span>
                            </div>
                            <h3 className="text-lg font-semibold mb-2">1. Add Customers</h3>
                            <p className="text-gray-600">Register customers with their WhatsApp numbers and addresses</p>
                        </div>
                        <div className="text-center">
                            <div className="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span className="text-2xl">📊</span>
                            </div>
                            <h3 className="text-lg font-semibold mb-2">2. Input Usage</h3>
                            <p className="text-gray-600">Enter monthly cubic meter usage and set billing rates</p>
                        </div>
                        <div className="text-center">
                            <div className="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span className="text-2xl">🧾</span>
                            </div>
                            <h3 className="text-lg font-semibold mb-2">3. Generate Invoices</h3>
                            <p className="text-gray-600">Automatically create invoices with PDF download</p>
                        </div>
                        <div className="text-center">
                            <div className="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span className="text-2xl">📱</span>
                            </div>
                            <h3 className="text-lg font-semibold mb-2">4. Send Notifications</h3>
                            <p className="text-gray-600">Automated WhatsApp messages and payment reminders</p>
                        </div>
                    </div>
                </div>
            </section>

            {/* CTA Section */}
            <section className="bg-gradient-to-r from-blue-600 to-indigo-700 py-16">
                <div className="container mx-auto px-6 text-center">
                    <h2 className="text-3xl md:text-4xl font-bold text-white mb-4">
                        Ready to Streamline Your Water Billing?
                    </h2>
                    <p className="text-xl text-blue-100 mb-8">
                        Join water utilities using AquaBill Pro to automate their billing process
                    </p>
                    <div className="flex flex-col sm:flex-row gap-4 justify-center">
                        <Button 
                            size="lg" 
                            variant="secondary"
                            onClick={handleGetStarted}
                            className="text-lg px-8 py-3"
                        >
                            🚀 Get Started Free
                        </Button>
                        <Button 
                            size="lg" 
                            variant="outline"
                            onClick={handleViewDemo}
                            className="text-lg px-8 py-3 border-white text-white hover:bg-white hover:text-blue-600"
                        >
                            📞 Schedule Demo
                        </Button>
                    </div>
                </div>
            </section>

            {/* Footer */}
            <footer className="bg-gray-900 text-white py-8">
                <div className="container mx-auto px-6">
                    <div className="flex flex-col md:flex-row justify-between items-center">
                        <div className="flex items-center space-x-2 mb-4 md:mb-0">
                            <div className="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                <span className="text-white font-bold text-lg">💧</span>
                            </div>
                            <span className="text-xl font-bold">AquaBill Pro</span>
                        </div>
                        <p className="text-gray-400">
                            © 2024 AquaBill Pro. Professional water billing management system.
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    );
}