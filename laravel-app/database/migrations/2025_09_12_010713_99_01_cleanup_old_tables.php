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
        // This migration was intended to clean up old tables, but since the new
        // table structure uses prefixed names, the old tables don't exist.
        // This migration is now a no-op but we keep it for migration history.
        
        // The old table names that were supposed to be dropped don't exist:
        // - users (now sys_users)
        // - roles (now cfg_roles) 
        // - permissions (now cfg_permissions)
        // - user_profiles (now usr_profiles)
        // - user_roles (now rel_user_roles)
        // - role_permissions (now rel_role_permissions)
        // - user_permissions (now rel_user_permissions)
        // - sessions (now sys_sessions)
        // - cache (now sys_cache)
        // - cache_locks (now sys_cache_locks)
        // - jobs (now sys_jobs)
        // - job_batches (now sys_job_batches)
        // - failed_jobs (now sys_failed_jobs)
        
        // No action needed as the old tables never existed with these names
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Since this migration doesn't actually drop any tables (the old tables
        // never existed with the names it was trying to drop), there's nothing
        // to reverse. This is a no-op migration.
    }
};