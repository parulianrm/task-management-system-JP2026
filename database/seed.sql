INSERT INTO
    USERS (
        name,
        email,
        password_hash,
        role,
        is_active,
        updated_by
    )
VALUES (
        'Parulian R M',
        'parulian.manik@neuronworks.co.id',
        '$2y$10$9WMzq3Qiitvi0vUNQYEcfehljX1cNAtJjRMsjnam080MnegikeGMm',
        'Admin',
        TRUE,
        NULL
    ),
    (
        'Abrar Halomoan R M',
        'abrar@neuronworks.co.id',
        '$2y$10$9WMzq3Qiitvi0vUNQYEcfehljX1cNAtJjRMsjnam080MnegikeGMm',
        'Member',
        TRUE,
        1
    ),
    (
        'Rian Hidayat',
        'rian@neuronworks.co.id',
        '$2y$10$9WMzq3Qiitvi0vUNQYEcfehljX1cNAtJjRMsjnam080MnegikeGMm',
        'Member',
        FALSE,
        1
    );

INSERT INTO
    PROJECTS (
        name,
        description,
        status,
        start_date,
        target_date,
        updated_by
    )
VALUES (
        'E-Commerce Mobile App',
        'Aplikasi belanja mobile untuk pelanggan retail.',
        'Active',
        '2026-08-01',
        '2026-10-31',
        1
    ),
    (
        'HRIS Internal System',
        'Sistem informasi kepegawaian internal.',
        'Planning',
        '2026-09-01',
        '2026-12-01',
        1
    ),
    (
        'Payment Gateway Integration',
        'Integrasi payment gateway ke sistem checkout.',
        'Completed',
        '2026-06-01',
        '2026-08-15',
        1
    );

INSERT INTO
    TASKS (
        project_id,
        title,
        description,
        assignee_id,
        status,
        priority,
        due_date,
        updated_by
    )
VALUES
    -- Project 1: E-Commerce Mobile App
    (
        1,
        'Fix Auth API',
        'Perbaiki bug pada endpoint autentikasi yang gagal validasi token.',
        2,
        'To Do',
        'High',
        '2026-09-04',
        1
    ),
    (
        1,
        'Integrasi Payment Gateway',
        'Hubungkan sistem pembayaran ke proses checkout aplikasi mobile.',
        1,
        'In Progress',
        'High',
        '2026-09-20',
        1
    ),
    (
        1,
        'Desain Halaman Checkout',
        'Buat desain UI halaman checkout yang responsif.',
        2,
        'Done',
        'Medium',
        '2026-09-14',
        1
    ),
    (
        1,
        'Review Security Checklist',
        'Audit keamanan dasar sebelum rilis.',
        2,
        'To Do',
        'High',
        '2026-09-06',
        1
    ),
    (
        1,
        'Setup CI Pipeline',
        'Konfigurasi pipeline build & test otomatis.',
        1,
        'To Do',
        'Medium',
        '2026-10-01',
        1
    ),
    (
        1,
        'Optimasi Performance API',
        'Tingkatkan response time endpoint utama.',
        1,
        'In Progress',
        'Low',
        '2026-10-15',
        1
    ),
    (
        1,
        'Buat Dokumentasi API',
        'Tulis dokumentasi endpoint API yang sudah dibuat.',
        1,
        'To Do',
        'Low',
        '2026-10-25',
        1
    ),
    (
        1,
        'Testing Modul Checkout',
        'Uji coba proses checkout end-to-end.',
        2,
        'To Do',
        'Medium',
        '2026-09-25',
        1
    ),
    (
        1,
        'Perbaikan Bug Login',
        'Perbaiki bug redirect setelah login gagal.',
        1,
        'Done',
        'High',
        '2026-08-20',
        1
    ),
    (
        1,
        'Setup Push Notification',
        'Integrasi notifikasi order untuk mobile app.',
        2,
        'To Do',
        'Medium',
        '2026-10-10',
        1
    ),
    -- Project 2: HRIS Internal System
    (
        2,
        'Design ERD Diagram',
        'Rancang ERD untuk modul HRIS, termasuk relasi antar tabel.',
        2,
        'In Progress',
        'Medium',
        '2026-09-15',
        1
    ),
    (
        2,
        'Setup Database HRIS',
        'Siapkan skema database awal untuk modul HRIS.',
        1,
        'To Do',
        'High',
        '2026-09-10',
        1
    ),
    (
        2,
        'Analisis Kebutuhan Payroll',
        'Kumpulkan requirement perhitungan payroll dari HR.',
        2,
        'Done',
        'Medium',
        '2026-09-05',
        1
    ),
    (
        2,
        'Wireframe Modul Absensi',
        'Buat wireframe low-fi untuk modul absensi.',
        1,
        'To Do',
        'Low',
        '2026-10-01',
        1
    ),
    (
        2,
        'Testing Modul Payroll',
        'Uji coba perhitungan payroll untuk berbagai skenario.',
        1,
        'In Progress',
        'Medium',
        '2026-11-01',
        1
    ),
    (
        2,
        'Update Dependency',
        'Update dependency Composer yang sudah usang.',
        2,
        'To Do',
        'Low',
        '2026-11-15',
        1
    ),
    (
        2,
        'Setup Role & Permission',
        'Konfigurasi hak akses Admin/Member di modul HRIS.',
        1,
        'To Do',
        'High',
        '2026-10-20',
        1
    ),
    (
        2,
        'Integrasi Absensi Fingerprint',
        'Hubungkan sistem absensi ke alat fingerprint.',
        2,
        'To Do',
        'Medium',
        '2026-11-25',
        1
    ),
    (
        2,
        'Dokumentasi Modul HRIS',
        'Tulis dokumentasi teknis modul HRIS.',
        1,
        'To Do',
        'Low',
        '2026-12-01',
        1
    ),
    -- Project 3: Payment Gateway Integration
    (
        3,
        'Midtrans Integration',
        'Integrasikan payment gateway Midtrans ke proses checkout.',
        3,
        'Done',
        'Low',
        '2026-08-10',
        1
    ),
    (
        3,
        'Fix Pagination Bug',
        'Perbaiki bug pagination yang salah hitung total halaman.',
        1,
        'Done',
        'Medium',
        '2026-07-20',
        1
    ),
    (
        3,
        'Optimasi Query Report',
        'Optimalkan query laporan yang lambat.',
        2,
        'Done',
        'Low',
        '2026-08-05',
        1
    ),
    (
        3,
        'Setup Webhook Payment',
        'Konfigurasi webhook notifikasi status pembayaran.',
        1,
        'Done',
        'High',
        '2026-07-01',
        1
    ),
    (
        3,
        'Testing Refund Flow',
        'Uji coba alur pengembalian dana.',
        2,
        'Done',
        'Medium',
        '2026-08-12',
        1
    ),
    (
        3,
        'Perbaikan UI Mobile Payment',
        'Perbaiki tampilan UI yang rusak di layar kecil.',
        2,
        'Done',
        'Medium',
        '2026-07-15',
        1
    ),
    (
        3,
        'Audit Keamanan Transaksi',
        'Audit keamanan dasar pada alur transaksi.',
        1,
        'Done',
        'High',
        '2026-08-14',
        1
    ),
    (
        3,
        'Dokumentasi API Payment',
        'Tulis dokumentasi endpoint API payment gateway.',
        1,
        'Done',
        'Low',
        '2026-07-25',
        1
    );