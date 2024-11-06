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
        Schema::dropIfExists('users');

        // Retrieve fields from the config file
        $fields = config('custom_login.fields');

        // Create the 'users' table dynamically based on config fields
        Schema::create('users', function (Blueprint $table) use ($fields) {
            $table->id();
            foreach ($fields as $fieldName => $fieldDetails) {
                $type = $fieldDetails['type'];
                $isRequired = $fieldDetails['required'] ?? false;

                // Add field based on type from config
                $column = $table->$type($fieldName);

                // Set length for string columns, if specified
                if (isset($fieldDetails['length'])) {
                    $column->length($fieldDetails['length']);
                }

                // Set field to nullable if not required
                if (!$isRequired) {
                    $column->nullable();
                }
            }

            // Additional default fields
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
