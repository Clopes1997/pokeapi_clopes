<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Perfil
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function clearErrors(form) {
                const errorElements = form.querySelectorAll('.mt-2 > ul, .mt-2 > div');
                errorElements.forEach(el => el.remove());
            }

            function showMessage(containerId, message, isError = false) {
                const container = document.getElementById(containerId);
                if (!container) return;

                container.innerHTML = '';
                const messageEl = document.createElement('p');
                messageEl.className = isError 
                    ? 'text-sm text-red-600 font-medium' 
                    : 'text-sm text-green-600 font-medium';
                messageEl.textContent = message;
                messageEl.setAttribute('x-data', '{ show: true }');
                messageEl.setAttribute('x-show', 'show');
                messageEl.setAttribute('x-transition', '');
                messageEl.setAttribute('x-init', `setTimeout(() => show = false, ${isError ? 5000 : 5000})`);
                container.appendChild(messageEl);

                if (!isError) {
                    setTimeout(() => {
                        container.innerHTML = '';
                    }, 5000);
                }
            }

            function displayErrors(form, errors) {
                clearErrors(form);
                
                Object.keys(errors).forEach(field => {
                    const input = form.querySelector(`[name="${field}"]`);
                    if (input) {
                        const parentDiv = input.closest('div');
                        let errorContainer = parentDiv.querySelector('.mt-2');
                        
                        if (!errorContainer) {
                            errorContainer = document.createElement('div');
                            errorContainer.className = 'mt-2';
                            parentDiv.appendChild(errorContainer);
                        } else {
                            const existingUl = errorContainer.querySelector('ul');
                            if (existingUl) {
                                existingUl.remove();
                            }
                        }
                        
                        const errorList = document.createElement('ul');
                        errorList.className = 'text-sm text-red-600 space-y-1';
                        const errorArray = Array.isArray(errors[field]) ? errors[field] : [errors[field]];
                        errorArray.forEach(error => {
                            const li = document.createElement('li');
                            li.textContent = error;
                            errorList.appendChild(li);
                        });
                        errorContainer.appendChild(errorList);
                    }
                });
            }

            const updateProfileForm = document.querySelector('form[action="{{ route('profile.update') }}"]');
            if (updateProfileForm) {
                updateProfileForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const submitButton = this.querySelector('button[type="submit"], input[type="submit"]');
                    const originalText = submitButton ? submitButton.textContent : '';
                    
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.textContent = 'Salvando...';
                    }

                    try {
                        const response = await fetch(this.action, {
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        const contentType = response.headers.get('content-type');
                        if (!contentType || !contentType.includes('application/json')) {
                            window.location.reload();
                            return;
                        }

                        const data = await response.json();

                        if (response.ok) {
                            clearErrors(this);
                            showMessage('profile-update-message', 'Perfil atualizado com sucesso!');
                            const nameInput = this.querySelector('[name="name"]');
                            const emailInput = this.querySelector('[name="email"]');
                            if (nameInput && data.name) nameInput.value = data.name;
                            if (emailInput && data.email) emailInput.value = data.email;
                        } else {
                            if (data.errors) {
                                displayErrors(this, data.errors);
                            }
                            if (data.message) {
                                showMessage('profile-update-message', data.message, true);
                            }
                        }
                    } catch (error) {
                        showMessage('profile-update-message', 'Erro ao atualizar perfil. Tente novamente.', true);
                    } finally {
                        if (submitButton) {
                            submitButton.disabled = false;
                            submitButton.textContent = originalText;
                        }
                    }
                });
            }

            const updatePasswordForm = document.querySelector('form[action="{{ route('password.update') }}"]');
            if (updatePasswordForm) {
                updatePasswordForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const submitButton = this.querySelector('button[type="submit"], input[type="submit"]');
                    const originalText = submitButton ? submitButton.textContent : '';
                    
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.textContent = 'Salvando...';
                    }

                    try {
                        const response = await fetch(this.action, {
                            method: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        const contentType = response.headers.get('content-type');
                        if (!contentType || !contentType.includes('application/json')) {
                            window.location.reload();
                            return;
                        }

                        const data = await response.json();

                        if (response.ok) {
                            clearErrors(this);
                            showMessage('password-update-message', 'Senha atualizada com sucesso!');
                            this.querySelector('[name="current_password"]').value = '';
                            this.querySelector('[name="password"]').value = '';
                            this.querySelector('[name="password_confirmation"]').value = '';
                        } else {
                            if (data.errors) {
                                displayErrors(this, data.errors);
                            }
                            if (data.message) {
                                showMessage('password-update-message', data.message, true);
                            }
                        }
                    } catch (error) {
                        showMessage('password-update-message', 'Erro ao atualizar senha. Tente novamente.', true);
                    } finally {
                        if (submitButton) {
                            submitButton.disabled = false;
                            submitButton.textContent = originalText;
                        }
                    }
                });
            }

            const deleteAccountForm = document.getElementById('delete-account-form');
            if (deleteAccountForm) {
                deleteAccountForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const formData = new FormData(this);
                    const submitButton = this.querySelector('button[type="submit"]');
                    const cancelButton = this.querySelector('button[type="button"]');
                    const originalText = submitButton ? submitButton.textContent : '';
                    const errorContainer = document.getElementById('delete-account-errors');
                    
                    if (errorContainer) {
                        errorContainer.innerHTML = '';
                    }
                    
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.textContent = 'Excluindo...';
                    }
                    
                    if (cancelButton) {
                        cancelButton.disabled = true;
                    }

                    try {
                        const csrfToken = document.querySelector('input[name="_token"]')?.value;
                        const response = await fetch(this.action, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        const data = await response.json();

                        if (response.ok) {
                            if (data.redirect) {
                                window.location.href = data.redirect;
                            } else {
                                window.location.href = '/';
                            }
                        } else {
                            if (errorContainer) {
                                errorContainer.innerHTML = '';
                                
                                if (data.errors) {
                                    const errorList = document.createElement('ul');
                                    errorList.className = 'text-sm text-red-600 space-y-1';
                                    const passwordErrors = Array.isArray(data.errors.password) 
                                        ? data.errors.password 
                                        : (data.errors.password ? [data.errors.password] : []);
                                    passwordErrors.forEach(error => {
                                        const li = document.createElement('li');
                                        li.textContent = error;
                                        errorList.appendChild(li);
                                    });
                                    if (passwordErrors.length > 0) {
                                        errorContainer.appendChild(errorList);
                                    }
                                } else if (data.message) {
                                    const errorP = document.createElement('p');
                                    errorP.className = 'text-sm text-red-600';
                                    errorP.textContent = data.message;
                                    errorContainer.appendChild(errorP);
                                }
                            }
                            
                            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'confirm-user-deletion' }));
                        }
                    } catch (error) {
                        console.error('Erro ao excluir conta:', error);
                        if (errorContainer) {
                            errorContainer.innerHTML = '<p class="text-sm text-red-600">Erro ao excluir conta. Tente novamente.</p>';
                        }
                        window.dispatchEvent(new CustomEvent('open-modal', { detail: 'confirm-user-deletion' }));
                    } finally {
                        if (submitButton) {
                            submitButton.disabled = false;
                            submitButton.textContent = originalText;
                        }
                        if (cancelButton) {
                            cancelButton.disabled = false;
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
