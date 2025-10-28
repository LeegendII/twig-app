<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1>Ticket Management</h1>
        <p class="text-secondary">Manage and track all your tickets</p>
    </div>
    <a href="/twig-app/index.php?route=create-ticket" class="btn btn-primary">Create New Ticket</a>
</div>

<!-- Tickets List -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Tickets</h3>
        <div class="d-flex align-items-center gap-3">
            <div>
                <label for="filter" class="form-label mb-0 me-2">Filter:</label>
                <select id="filter" name="filter" class="form-control form-control-sm d-inline-block" style="width: auto" onchange="window.location.href='/twig-app/index.php?route=tickets&filter=' + this.value">
                    <option value="all" <?php echo $filter === 'all' ? 'selected' : ''; ?>>All Tickets</option>
                    <option value="open" <?php echo $filter === 'open' ? 'selected' : ''; ?>>Open</option>
                    <option value="in_progress" <?php echo $filter === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                    <option value="closed" <?php echo $filter === 'closed' ? 'selected' : ''; ?>>Closed</option>
                </select>
            </div>
            <span class="badge bg-secondary"><?php echo count($filteredTickets); ?> tickets</span>
        </div>
    </div>
    
    <div class="card-body">
        <?php if (!empty($filteredTickets)): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Last Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($filteredTickets as $ticket): ?>
                            <tr>
                                <td>
                                    <div>
                                        <strong><?php echo htmlspecialchars($ticket['title']); ?></strong>
                                    </div>
                                </td>
                                <td>
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
                                    <span class="badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                </td>
                                <td>
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
                                    <span class="badge <?php echo $priorityClass; ?>"><?php echo $priorityText; ?></span>
                                </td>
                                <td><?php echo relativeTime($ticket['updatedAt']); ?></td>
                                <td>
                                    <a href="/twig-app/index.php?route=ticket-detail&id=<?php echo $ticket['id']; ?>" class="btn btn-sm btn-outline-primary">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-4">
                <p class="text-secondary">No tickets found.</p>
                <a href="/twig-app/index.php?route=create-ticket" class="btn btn-primary">Create Your First Ticket</a>
            </div>
        <?php endif; ?>
    </div>
</div>