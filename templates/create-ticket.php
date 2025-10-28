<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1>Create New Ticket</h1>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <?php if (isset($ticketError)): ?>
            <div class="alert alert-danger"><?php echo $ticketError; ?></div>
        <?php endif; ?>
        
        <form method="post" action="/twig-app/index.php?route=create-ticket">
            <div class="form-group">
                <label for="title" class="form-label">Title *</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    class="form-control"
                    value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>"
                    placeholder="Enter ticket title"
                    required
                />
            </div>
            
            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea
                    id="description"
                    name="description"
                    class="form-control"
                    placeholder="Enter ticket description"
                    rows="4"
                ><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label for="status" class="form-label">Status *</label>
                        <select
                            id="status"
                            name="status"
                            class="form-control"
                        >
                            <option value="open" <?php echo (isset($_POST['status']) && $_POST['status'] === 'open') ? 'selected' : ''; ?>>Open</option>
                            <option value="in_progress" <?php echo (isset($_POST['status']) && $_POST['status'] === 'in_progress') ? 'selected' : ''; ?>>In Progress</option>
                            <option value="closed" <?php echo (isset($_POST['status']) && $_POST['status'] === 'closed') ? 'selected' : ''; ?>>Closed</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-col">
                    <div class="form-group">
                        <label for="priority" class="form-label">Priority</label>
                        <select
                            id="priority"
                            name="priority"
                            class="form-control"
                        >
                            <option value="low" <?php echo (isset($_POST['priority']) && $_POST['priority'] === 'low') ? 'selected' : ''; ?>>Low</option>
                            <option value="medium" <?php echo (!isset($_POST['priority']) || (isset($_POST['priority']) && $_POST['priority'] === 'medium')) ? 'selected' : ''; ?>>Medium</option>
                            <option value="high" <?php echo (isset($_POST['priority']) && $_POST['priority'] === 'high') ? 'selected' : ''; ?>>High</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">Create Ticket</button>
                <a href="/twig-app/index.php?route=tickets" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>