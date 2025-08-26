<!-- Bootstrap JS -->
    <script src="https://getbootstrap.com/docs/5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        class="astro-vvvwv3sm">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
            document.addEventListener('DOMContentLoaded', function() {
                // หาปุ่ม .btn-minus ทั้งหมดในหน้า
                document.querySelectorAll('.btn-minus').forEach(function(button) {
                    button.addEventListener('click', function() {
                        // หา input ที่อยู่ใกล้ที่สุด
                        var input = this.closest('.input-group').querySelector('.quantity-input');
                        var currentValue = parseInt(input.value);
                        // ลดค่าลง 1 แต่ไม่ให้ต่ำกว่า 1
                        if (currentValue > 1) {
                            input.value = currentValue - 1;
                        }
                    });
                });

                // หาปุ่ม .btn-plus ทั้งหมดในหน้า
                document.querySelectorAll('.btn-plus').forEach(function(button) {
                    button.addEventListener('click', function() {
                        // หา input ที่อยู่ใกล้ที่สุด
                        var input = this.closest('.input-group').querySelector('.quantity-input');
                        var currentValue = parseInt(input.value);
                        // เพิ่มค่าขึ้น 1 แต่ไม่ให้เกิน 99
                        if (currentValue < 99) {
                            input.value = currentValue + 1;
                        }
                    });
                });
            });
    </script>

    @if(session('alert-message'))
        <script>
            alert("{{ session('alert-message') }}");
        </script>
    @endif