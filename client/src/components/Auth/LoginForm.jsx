import React, {useState} from 'react'
import {login} from '../../services/api';
const LoginForm = () => {
    const [email,setEmail]=useState('');
    const [password,setPassword]=useState('');
    const [error,setError]=useState('');
    const handleLogin = async (e) => {
        e.preventDefault();
        const data = await login({ email, password });

        if (data.status ==='success') {
            
          localStorage.setItem("userID",data.id);
          localStorage.setItem("username",data.username);
          window.location.href='/';
        }else{
            setError(data.message);
        }
      };
  return (
        <div>
            <form onSubmit={handleLogin}>
                <input 
                    type="email" 
                    placeholder="Email" 
                    value={email} 
                    onChange={(e) => setEmail(e.target.value)} 
                />
                <input 
                    type="password" 
                    placeholder="Password" 
                    value={password} 
                    onChange={(e) => setPassword(e.target.value)} 
                />
                <button type="submit">Login</button>
            </form>
                {error && <div>{error}</div>}
        </div>
   
  )
}

export default LoginForm