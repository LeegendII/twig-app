<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1>Dashboard</h1>
        <p class="text-secondary">Welcome back, <?php echo htmlspecialchars($_SESSION['user']['name']); ?>!</p>
    </div>
    <a href="/twig-app/index.php?route=tickets" class="btn btn-primary">Manage Tickets</a>
</div>

<!-- Stats Cards -->
<div class="stats-container">
    <div class="stat-card">
        <div class="stat-value"><?php echo $ticketStats['total']; ?></div>
        <div class="stat-label">Total Tickets</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value" style="color: var(--success-color)"><?php echo $ticketStats['open']; ?></div>
        <div class="stat-label">Open Tickets</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value" style="color: var(--warning-color)"><?php echo $ticketStats['inProgress']; ?></div>
        <div class="stat-label">In Progress</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value" style="color: var(--gray-color)"><?php echo $ticketStats['closed']; ?></div>
        <div class="stat-label">Closed Tickets</div>
    </div>
</div>

<!-- Recent Tickets -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Recent Tickets</h3>
        <a href="/twig-app/index.php?route=tickets" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    
    <div class="card-body">
        <?php if (!empty($_SESSION['tickets'])): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Last Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Get recent tickets (last 5)
                        $recentTickets = $_SESSION['tickets'];
                        usort($recentTickets, function($a, $b) {
                            return strtotime($b['updatedAt']) - strtotime($a['updatedAt']);
                        });
                        $recentTickets = array_slice($recentTickets, 0, 5);
                        
                        foreach ($recentTickets as $ticket): 
                        ?>
                            <tr>
                                <td>
                                    <div>
                                        <strong><?php echo htmlspecialchars($ticket['title']); ?></strong>
                                        <?php if ($ticket['priority'] === 'high'): ?>
                                            <span class="badge badge-danger ms-2">High Priority</span>
                                        <?php endif; ?>
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