      
        function showForm(formType) {
           
            document.getElementById('signin-form').classList.remove('active');
            document.getElementById('signup-form').classList.remove('active');
            
           
            let tabs = document.querySelectorAll('.tab-button');
            tabs.forEach(function(tab) {
                tab.classList.remove('active');
            });
            
            
            if (formType === 'signin') {
                document.getElementById('signin-form').classList.add('active');
                tabs[0].classList.add('active');
            } else {
                document.getElementById('signup-form').classList.add('active');
                tabs[1].classList.add('active');
            }
        }

       
        function handleSignIn(event) {
            event.preventDefault();
            
            let email = document.getElementById('signin-email').value;
            let password = document.getElementById('signin-password').value;
            
           
            if (email && password) {
                alert('Sign in successful! Welcome back to ShopVibe.');
                
                window.location.href = 'index.html';
            } else {
                alert('Please fill in all fields.');
            }
        }

        
        function handleSignUp(event) {
            event.preventDefault();
            
            let name = document.getElementById('signup-name').value;
            let email = document.getElementById('signup-email').value;
            let password = document.getElementById('signup-password').value;
            let confirm = document.getElementById('signup-confirm').value;
            
           
            if (name && email && password && confirm) {
                if (password === confirm) {
                    alert('Account created successfully! Welcome to ShopVibe.');
                   
                    window.location.href = 'index.html';
                } else {
                    alert('Passwords do not match.');
                }
            } else {
                alert('Please fill in all fields.');
            }
        }

        
        function socialLogin(provider) {
            alert('Redirecting to ' + provider + ' login...');
           
        }

        
        document.querySelectorAll('a[href^="#"]').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                let target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });