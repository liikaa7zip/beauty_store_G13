<?php require_once 'layouts/header.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Activity Feed</h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10%">Type</th>
                                <th style="width: 60%">Description</th>
                                <th style="width: 15%">User</th>
                                <th style="width: 15%">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($activities as $activity): ?>
                            <tr>
                                <td>
                                    <span class="badge 
                                        <?php 
                                        switch($activity['type']) {
                                            case 'login': echo 'bg-primary'; break;
                                            case 'product': echo 'bg-success'; break;
                                            case 'category': echo 'bg-info'; break;
                                            case 'promotion': echo 'bg-warning'; break;
                                            case 'sale': echo 'bg-danger'; break;
                                            default: echo 'bg-secondary';
                                        }
                                        ?>">
                                        <?= ucfirst($activity['type']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($activity['description']) ?></td>
                                <td><?= htmlspecialchars($activity['performed_by']) ?></td>
                                <td><?= date('M j, Y g:i a', strtotime($activity['timestamp'])) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require_once 'layouts/footer.php'; ?>
