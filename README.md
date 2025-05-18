# Elearning Platform - Usage Guide

<p align="center">
  <img src="public/dashboard/assets/media/logos/logo-default.svg" alt="Elearning-Platform" width="200"/>
</p>

## Login URLs

Below are the login URLs for different user roles:

- **Admin Dashboard:**
  [Login as Admin](http://127.0.0.1:8000/admin/login)

- **Teacher Portal:**
  [Login as Teacher](http://127.0.0.1:8000/teacher/login)

- **Academic Portal:**
  [Login as Academic](http://127.0.0.1:8000/academic/login)

## Repository Pattern Usage ::

To use the repository pattern in this project, follow these steps:

1. **Create an Interface:**

   Use the following command to generate a new interface:

   ```bash
   php artisan make:interface (interfaceName)

2. **Create an Repository:**

   Use the following command to generate a new repository:

   ```bash
   php artisan make:repository (repositoryName)


    Replace (repositoryName) with the name of your repository. For example, AdminRepository.

    Verify the Created Files:
        Ensure that the interface you created is located in the App\Repositories\Contracts directory. For example, AdminRepositoryInterface.
        Ensure that the repository implementation you created is located in the App\Repositories\Eloquents directory. For example, AdminRepository.

Make sure to define the methods in your interface and implement them in your repository to follow the repository pattern effectively


### Frontend Integration
1. **Component Integration:**
    * **_tpl_start.blade.php:** Includes `@yield('pageTitle')` within the `<head>` tag to dynamically set the page title.
    * **_tpl_end.blade.php:** Includes `@stack('css')` at the end of the `<body>` tag to stack additional CSS files.
2. **Usage Example:**
    ```html
    @extends('frontend.includes.site')
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    @endpush
    @section('title', 'Home Page')

    @section('content')


    @push('js')

    @endpush
    @endsection
