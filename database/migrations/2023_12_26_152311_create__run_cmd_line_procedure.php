<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared(
            "CREATE PROCEDURE [dbo].[RunCmdLine]
             @Command VARCHAR(8000) 
             AS 
             BEGIN
        SET NOCOUNT ON;
    
        DECLARE @Cmd VARCHAR(8000);
        SET @Cmd = 'cmd.exe /C ' + @Command;
    
        EXEC xp_cmdshell @Cmd;
    END;"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS RunCmdLine;');
    }
};
