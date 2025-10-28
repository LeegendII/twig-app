<div class="container my-5" style="max-width: 500px">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Login</h2>
            
            <?php if (isset($loginError)): ?>
                <div class="alert alert-danger"><?php echo $loginError; ?></div>
            <?php endif; ?>
            
            <form method="post" action="/twig-app/index.php?route=login">
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                        placeholder="Enter your email"
                        required
                    />
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="Enter your password"
                        required
                    />
                </div>
                
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            
            <div class="text-center mt-4">
                <p>Don't have an account? <a href="/twig-app/index.php?route=signup">Sign up</a></p>
            </div>
            
            <div class="mt-4 p-3 bg-light rounded">
                <h6 class="text-center">Demo Credentials</h6>
                <p class="mb-1"><strong>Email:</strong> admin@example.com</p>
                <p class="mb-0"><strong>Password:</strong> password123</p>
            </div>
        </div>
    </div>
</div>