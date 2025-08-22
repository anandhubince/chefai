<style>
    :root {
        --primary-color: #4CAF50;
        --primary-dark: #3e8e41;
        --text-color: #333;
        --background-color: #ffffff;
        --shadow-color: rgba(0, 0, 0, 0.1);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f0f2f5;
    }

    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 2rem;
        background-color: var(--background-color);
        box-shadow: 0 4px 12px var(--shadow-color);
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
    }

    .navbar-logo {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        text-decoration: none;
        transition: color 0.3s ease;
        white-space: nowrap;
    }

    .navbar-logo:hover {
        color: var(--primary-dark);
    }

    .nav-links {
        list-style: none;
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        padding: 0;
        margin: 0;
        overflow-x: auto; /* Enable horizontal scroll if needed */
        max-width: 70vw;  /* Prevent overflow on small screens */
    }

    .nav-item {
        margin-left: 0;
    }

    .nav-link {
        text-decoration: none;
        color: var(--text-color);
        font-size: 1rem;
        font-weight: 500;
        position: relative;
        transition: color 0.3s ease;
        padding: 0.5rem 0;
        white-space: nowrap; /* Prevent link text wrapping */
    }

    .nav-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background-color: var(--primary-color);
        transition: width 0.3s ease-in-out;
    }

    .nav-link:hover::after,
    .nav-link.active::after {
        width: 100%;
    }

    .nav-link:hover {
        color: var(--primary-dark);
    }

    .profile-btn {
        background-color: var(--primary-color);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        transition: transform 0.3s ease, background-color 0.3s ease;
        white-space: nowrap;
    }

    .profile-btn:hover {
        background-color: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 900px) {
        .nav-links {
            max-width: 100vw;
            gap: 0.5rem;
        }
        .profile-btn {
            font-size: 0.95rem;
            padding: 0.5rem 0.7rem;
        }
    }

    @media (max-width: 600px) {
        .navbar {
            flex-direction: column;
            align-items: flex-start;
            padding: 1rem;
        }
        .navbar-logo {
            margin-bottom: 1rem;
        }
        .nav-links {
            flex-direction: row;
            flex-wrap: wrap;
            gap: 0.5rem;
            width: 100%;
            justify-content: flex-start;
            overflow-x: auto;
        }
        .nav-item {
            margin: 0;
        }
        .profile-btn {
            font-size: 0.9rem;
            padding: 0.4rem 0.6rem;
        }
    }
</style>

<nav class="navbar">
    <a href="/ChefAI/User/user_homepage.php" class="navbar-logo">ChefAI</a>
    <ul class="nav-links">
        <li class="nav-item">
            <a href="/ChefAI/User/user_homepage.php" class="nav-link">Home</a>
        </li>
        <li class="nav-item">
            <a href="/ChefAI/User/generate_recipe.php" class="nav-link">Generate Recipe</a>
        </li>
        <li class="nav-item">
            <a href="/ChefAI/User/profile.php" class="nav-link profile-btn">Profile</a>
        </li>
    </ul>
</nav>