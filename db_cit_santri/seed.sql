USE db_cit_santri;

-- Example santri user: username zaky123, password cit2024 (stored as MD5)
INSERT INTO tb_santri (username, password, nama_lengkap, kelas, pengalaman)
VALUES (
  'zaky123',
  MD5('cit2024'),
  'Ahmad Zaky',
  '7 RPL 1',
  'Selama 3 bulan di CIT Boarding School, saya belajar disiplin, kemandirian, dan coding setiap pagi. Saya juga senang bisa hafalan Quran bersama teman-teman.'
);
