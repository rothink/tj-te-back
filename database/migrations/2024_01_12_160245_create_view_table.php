<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("CREATE OR REPLACE VIEW relation_view AS
            select
                a.id , 
                a.nome,
                GROUP_CONCAT( b.titulo SEPARATOR ',  ') as livros,
                GROUP_CONCAT(s.descricao SEPARATOR ',  ') as assuntos
            from
                authors a
            left join book_authors ba on
                ba.author_id = a.id
            left join books b on
                b.id = ba.book_id
            left join book_subjects bs on
                bs.book_id = b.id
            left join subjects s on
                s.id = bs.subject_id
            group by
                a.id          
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relation_view');
    }
};
