<div class="container my-5" style="max-width: 500px">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Sign Up</h2>
            
            <?php if (isset($signupError)): ?>
                <div class="alert alert-danger"><?php echo $signupError; ?></div>
            <?php endif; ?>
            
            <form method="post" action="/twig-app/index.php?route=signup">
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>"
                        placeholder="Enter your full name"
                        required
                    />
                </div>
                
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
                        minlength="6"
                    />
                </div>
                
                <div class="form-group">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <input
                        type="password"
                        id="confirmPassword"
                        name="confirmPassword"
                        class="form-control"
                        placeholder="Confirm your password"
                        required
                        minlength="6"
                    />
                </div>
                
                <button type="submit" class="btn btn-primary w-100">Sign Up</button>
            </form>
            
            <div class="text-center mt-4">
                <p>Already have an account? <a href="/twig-app/index.php?route=login">Login</a></p>
            </div>
        </div>
    </div>
</div>