        <?php
        use App\Models\User;
        use Illuminate\Foundation\Testing\RefreshDatabase;
        use App\Models\Tenant;
        use Illuminate\Support\Facades\Artisan;
        use App\Models\Project;

        uses( RefreshDatabase::class);


        beforeEach(function () {
            // Run landlord migrations
            Artisan::call('migrate:fresh', [
                '--database' => 'landlord',
                '--path' => 'database/migrations/landlord',
                '--seed' => true
            ]);

            $tenant = Tenant::create([
                'id' => \Symfony\Component\Uid\Ulid::generate(),
                'name' => 'Test Tenant',
                'domain' => 'testtenant.example.com',
                'database' => 'testing12345'
            ]);
            $tenant->makeCurrent();
            Artisan::call('tenants:artisan "migrate --database=tenant"');

            $this->adminUser = User::factory()->create();
            $this->adminUser->assignRole('admin');
            $this->memberUser = User::factory()->create();
            $this->memberUser->assignRole('member');
        });

        afterEach(function () {
            Artisan::call('migrate:rollback', ['--database' => 'tenant']);

            Tenant::forgetCurrent();
        });

        function actingAsRole($user)
        {
            test()->actingAs($user, 'api');
        }

        it('allows both admin and member to access user and project indexes', function () {
            actingAsRole($this->adminUser);
            test()->getJson(route('users.index'))->assertOk();
            test()->getJson(route('projects.index'))->assertOk();

            actingAsRole($this->memberUser);
            test()->getJson(route('users.index'))->assertOk();
            test()->getJson(route('projects.index'))->assertOk();
        });

        it('allows both admin and member to view a specific user and project', function () {
            $user = User::factory()->create();
            $project = Project::factory()->create();

            actingAsRole($this->adminUser);
            test()->getJson(route('users.show', ['user' => $user->id]))->assertOk();
            test()->getJson(route('projects.show', ['project' => $project->id]))->assertOk();

            actingAsRole($this->memberUser);
            test()->getJson(route('users.show', ['user' => $user->id]))->assertOk();
            test()->getJson(route('projects.show', ['project' => $project->id]))->assertOk();
        });

        it('allows only admins to create and delete users', function () {
            actingAsRole($this->adminUser);
            test()->postJson(route('users.store'), ['name' => 'New User', 'email' => 'new@example.com', 'password' => 'password'])->assertStatus(201);
            test()->deleteJson(route('users.destroy', ['user' => 1]))->assertStatus(204);

            actingAsRole($this->memberUser);
            test()->postJson(route('users.store'), ['name' => 'New User', 'email' => 'new@example.com', 'password' => 'password'])->assertForbidden();
            test()->deleteJson(route('users.destroy', ['user' => 1]))->assertForbidden();
        });

        it('rejects unauthenticated access to all routes', function () {
            test()->getJson(route('users.show', ['user' => 1]))->assertUnauthorized();
            test()->getJson(route('projects.show', ['project' => 1]))->assertUnauthorized();
            test()->postJson(route('users.store'), ['name' => 'Fail User'])->assertUnauthorized();
            test()->deleteJson(route('users.destroy', ['user' => 1]))->assertUnauthorized();
        });
