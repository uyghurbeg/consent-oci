<?php

declare(strict_types=1);

namespace OCI\Database\Migrations;

use OCI\Infrastructure\Database\Migration;

/**
 * The site code (SiteCreationService, SiteListHandler, SiteClaimService, agency health) reads and writes
 * oci_sites.suspended_reason, but no migration of the open-source release creates the column, so creating a
 * site failed with "Unknown column 'suspended_reason'". Self-hosted fork fix.
 */
final class Version20261012_001_AddSuspendedReasonToSites extends Migration
{
    public function getDescription(): string
    {
        return 'Add oci_sites.suspended_reason (used by site creation, claim and list handlers)';
    }

    public function up(): void
    {
        $this->sql("ALTER TABLE `oci_sites`
            ADD COLUMN IF NOT EXISTS `suspended_reason` VARCHAR(50) NULL DEFAULT NULL AFTER `status`");
    }

    public function down(): void
    {
        $this->sql('ALTER TABLE `oci_sites` DROP COLUMN IF EXISTS `suspended_reason`');
    }
}
