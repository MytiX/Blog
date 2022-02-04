        <footer class="blog-footer">
            <p>DevCoding</p>
            <?php if (!empty($user = $session->get('__user')) AND $user['role'] === "ROLE_ADMIN"): ?>
                <a class="btn btn-sm btn-outline-secondary mx-2" href="/admin/posts">Dashboard</a>
            <?php endif; ?>
        </footer>
    </body>
</html>
