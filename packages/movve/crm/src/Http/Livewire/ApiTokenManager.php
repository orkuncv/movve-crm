<?php

namespace Movve\Crm\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Jetstream;
use Livewire\Component;

class ApiTokenManager extends Component
{
    /**
     * The create API token form state.
     *
     * @var array
     */
    public $createApiTokenForm = [
        'name' => '',
        'permissions' => [],
    ];

    /**
     * Indicates if the plain text token is being displayed.
     *
     * @var bool
     */
    public $displayingToken = false;

    /**
     * The plain text token value.
     *
     * @var string|null
     */
    public $plainTextToken;

    /**
     * Indicates if the deletion confirmation modal is being displayed.
     *
     * @var bool
     */
    public $confirmingApiTokenDeletion = false;

    /**
     * The ID of the token being deleted.
     *
     * @var int|null
     */
    public $apiTokenIdBeingDeleted;

    /**
     * Get the available permissions.
     *
     * @return array
     */
    public function getPermissions()
    {
        return [
            'crm:access' => 'Access CRM functionality',
            'crm:read' => 'View contacts',
            'crm:create' => 'Create contacts',
            'crm:update' => 'Update contacts',
            'crm:delete' => 'Delete contacts',
            'crm:restore' => 'Restore deleted contacts',
        ];
    }

    /**
     * Create a new API token.
     *
     * @return void
     */
    public function createApiToken()
    {
        $this->resetErrorBag();

        $this->validate([
            'createApiTokenForm.name' => ['required', 'string', 'max:255'],
        ]);

        $permissions = array_keys(array_filter($this->createApiTokenForm['permissions']));

        if (!in_array('crm:access', $permissions)) {
            $permissions[] = 'crm:access';
        }

        $token = Auth::user()->createToken(
            $this->createApiTokenForm['name'],
            $permissions
        );

        $this->plainTextToken = explode('|', $token->plainTextToken)[1];
        $this->displayingToken = true;

        $this->createApiTokenForm = [
            'name' => '',
            'permissions' => [],
        ];

        $this->emit('created');
    }

    /**
     * Delete an API token.
     *
     * @param  int  $tokenId
     * @return void
     */
    public function deleteApiToken($tokenId)
    {
        Auth::user()->tokens()->where('id', $tokenId)->delete();
        $this->confirmingApiTokenDeletion = false;
        $this->emit('deleted');
    }

    /**
     * Confirm that the given API token should be deleted.
     *
     * @param  int  $tokenId
     * @return void
     */
    public function confirmApiTokenDeletion($tokenId)
    {
        $this->confirmingApiTokenDeletion = true;
        $this->apiTokenIdBeingDeleted = $tokenId;
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('crm::api-tokens.manager', [
            'tokens' => Auth::user()->tokens,
            'availablePermissions' => $this->getPermissions(),
            'defaultPermissions' => Jetstream::$defaultPermissions,
        ]);
    }
}
