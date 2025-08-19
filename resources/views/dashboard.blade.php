@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="text-primary mb-4">Welcome to the Admin Dashboard</h1>
@stop

@section('content')
    <style>
        .dashboard-card {
            border-radius: 1rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            background: #ffffff;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
        }

        .dashboard-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #f1f1f1;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .dashboard-card a {
            color: inherit;
            text-decoration: none;
        }
        .cke_notifications_area{
            display: none;
        }
    </style>

    @php
        $dashboardLinks = [
            ['title' => 'Homepage', 'url' => 'admin/homepage', 'icon' => 'fas fa-home', 'color' => 'text-success'],
            ['title' => 'Catalogue', 'url' => 'admin/catalogue', 'icon' => 'fas fa-book-open', 'color' => 'text-primary'],
            ['title' => 'About Us', 'url' => 'admin/about-us', 'icon' => 'fas fa-info-circle', 'color' => 'text-info'],
            ['title' => 'Career Page', 'url' => 'admin/career', 'icon' => 'fas fa-briefcase', 'color' => 'text-warning'],
            ['title' => 'Customer Care', 'url' => 'admin/customer-care', 'icon' => 'fas fa-headset', 'color' => 'text-danger'],
            ['title' => 'Collections', 'url' => 'admin/collections', 'icon' => 'fas fa-layer-group', 'color' => 'text-teal'],
            ['title' => 'Categories', 'url' => 'admin/categories', 'icon' => 'fas fa-th-list', 'color' => 'text-indigo'],
            ['title' => 'Blogs', 'url' => 'admin/blogs', 'icon' => 'fas fa-book', 'color' => 'text-pink'],
        ];
    @endphp

    <div class="row">
        @foreach ($dashboardLinks as $link)
            <div class="col-md-6 col-lg-3 mb-4">
                <a href="{{ url($link['url']) }}">
                    <div class="dashboard-card p-4 text-center h-100">
                        <div class="dashboard-icon mx-auto {{ $link['color'] }}">
                            <i class="{{ $link['icon'] }}"></i>
                        </div>
                        <h5 class="mt-2">{{ $link['title'] }}</h5>
                        <p class="text-muted small">Go to {{ $link['title'] }}</p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@stop
