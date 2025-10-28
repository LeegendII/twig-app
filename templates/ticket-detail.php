<?php if ($ticket): ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Ticket Details</h1>
        </div>
        <div>
            <a href="/twig-app/index.php?route=edit-ticket&id=<?php echo $ticket['id']; ?>" class="btn btn-sm btn-outline-primary me-2">Edit</a>
            <a href="/twig-app/index.php?route=delete-ticket&id=<?php echo $ticket['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this ticket?')">Delete</a>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h4 class="mb-0"><?php echo htmlspecialchars($ticket['title']); ?></h4>
                <div>
                    <?php 
                    $statusClass = 'badge-secondary';
                    $statusText = htmlspecialchars($ticket['status']);
                    
                    if ($ticket['status'] === 'open') {
                        $statusClass = 'badge-success';
                        $statusText = 'Open';
                    } elseif ($ticket['status'] === 'in_progress') {
                        $statusClass = 'badge-warning';
                        $statusText = 'In Progress';
                    } elseif ($ticket['status'] === 'closed') {
                        $statusClass = 'badge-gray';
                        $statusText = 'Closed';
                    }
                    ?>
                    <span class="badge <?php echo $statusClass; ?> me-2"><?php echo $statusText; ?></span>
                    
                    <?php 
                    $priorityClass = 'badge-secondary';
                    $priorityText = htmlspecialchars($ticket['priority']);
                    
                    if ($ticket['priority'] === 'high') {
                        $priorityClass = 'badge-danger';
                    } elseif ($ticket['priority'] === 'medium') {
                        $priorityClass = 'badge-warning';
                    } elseif ($ticket['priority'] === 'low') {
                        $priorityClass = 'badge-success';
                    }
                    
                    $priorityText = ucfirst($priorityText);
                    ?>
                    <span class="badge <?php echo $priorityClass; ?>"><?php echo $priorityText; ?> Priority</span>
                </div>
            </div>
            
            <?php if (!empty($ticket['description'])): ?>
                <div class="mb-4">
                    <h5>Description</h5>
                    <p><?php echo htmlspecialchars($ticket['description']); ?></p>
                </div>
            <?php endif; ?>
            
            <div class="row text-sm text-secondary">
                <div class="col-md-4">
                    <strong>Created:</strong> <?php echo formatDate($ticket['createdAt']); ?>
                </div>
                <div class="col-md-4">
                    <strong>Last Updated:</strong> <?php echo relativeTime($ticket['updatedAt']); ?>
                </div>
                <div class="col-md-4">
                    <strong>ID:</strong> #<?php echo $ticket['id']; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-between">
        <a href="/twig-app/index.php?route=tickets" class="btn btn-secondary">Back to Tickets</a>
        <a href="/twig-app/index.php?route=edit-ticket&id=<?php echo $ticket['id']; ?>" class="btn btn-primary">Edit Ticket</a>
    </div>
<?php else: ?>
    <div class="alert alert-danger">Ticket not found.</div>
    <a href="/twig-app/index.php?route=tickets" class="btn btn-primary">Back to Tickets</a>
<?php endif; ?>