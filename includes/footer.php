            </div> <!-- End content-wrapper -->
        </main>
    </div> <!-- End dashboard-container -->
    
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Simple mobile sidebar toggle
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });

        // SweetAlert for Delete confirmations
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                let msg = this.getAttribute('data-confirm-msg') || 'Are you sure you want to delete this?';
                Swal.fire({
                    title: 'Are you sure?',
                    text: msg,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
</body>
</html>

