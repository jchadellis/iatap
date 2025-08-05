 <style>
        body, html {
            height: 100%;
            margin: 0;
        }
        .wrapper {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        .content {
            display: flex;
            flex: 1;
            overflow: hidden;
        }
        .sidebar {
            width: 250px;
            background:var(--bs-dark);
            color: white;
            padding: 1rem;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 0.5rem 0;
        }
        .sidebar a:hover {
            
        }
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: auto;
        }
        .navbar, .footer {
            flex-shrink: 0;
            background: #f8f9fa;
            padding: 1rem;
            text-align: center;
        }
        .footer {
            background: #f8f9fa;
            padding: 1rem;
            text-align: center;
            margin-top: auto;
        }
        .vr{
            height: 30px; 
            margin-top: .5em; 
            margin-right: .5em; 
            margin-left: 1em;
        }

        .breadcrumb {
            display: flex;
            flex-wrap: wrap;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            list-style: none;
            background-color: #eaecf4;
            border-radius: 0.35rem;
        }

        .nav-link:hover{
            color: var(--bs-gray-500);
        }

        .btn-xs{
            --bs-btn-padding-y: .25rem; 
            --bs-btn-padding-x: .5rem; 
            --bs-btn-font-size: .75rem;
        }

        .arrow-icon{
            display: inline-block;
            transition: transform 0.3s; 
            transform: rotate(0deg);
        }

        .rotate{
            transition: transform 0.3s; 
            transform: rotate(90deg);
        }

        .bg-custom-1{
            background-color: #dde6ee;
        }

        .bg-gray-600{
            background-color: #6c757d;
            color: #f8f9fa;
        }

        .bg-gray-600:hover{
            background-color: #e9ecef;
            color: #6C757D;
        }

        .bg-gray-100{
            background-color:rgb(218, 218, 218); 
            color: #6c757d;
        }

        .bg-gray-100:hover{
            background-color: #6c757d;
            color: #f8f9fa;
        }

         .bg-breadcrumb{
            background-color: rgb(218, 218, 218);
            color:rgb(71, 91, 107);
        }

        .bg-breadcrumb a:hover{
            color: rgb(161 102 85) !important;
        }

        .btn-danger{
            background-color: #BE3D2A; 
            color: #f8f9fa;
        }

        .btn-success{
            background-color: #808836;
            border-color:  #808836;
            color: #f8f9fa;
        }
        
        .btn-success:hover,
        .btn-success:focus,

        .btn-success:active,
        .btn-success.active,
        .show > .btn-success.dropdown-toggle {
            background-color: #9aa64c;
            border-color: #5e6e25;      
            color: #fff;                
            box-shadow: none;           
            outline: none;             
        }
    </style>


<style>
    .widget-icon{
        width: 4.25em; 
        height: 4.25em; 
    }

    .widget-icon-tables{
        background-color:rgb(105, 108, 133);
    }
    .widget-icon-documents{
        background-color:rgb(133, 105, 114);
    }
    .icon{
        font-size: 2.5rem; 
        color:rgb(244, 244, 244);
    }

</style>