import React, {useState} from 'react'
import {login} from '../../services/api';
import {Link, useNavigate} from 'react-router-dom';
import "./LoginForm.css";
const LoginForm = () => {
    const navigate = useNavigate();
    const [email,setEmail]=useState('');
    const [password,setPassword]=useState('');
    const [error,setError]=useState('');
    const handleLogin = async (e) => {
        e.preventDefault();
        const data = await login({ email, password });

        if (data.status ==='success') {
            
          localStorage.setItem("userID",data.id);
          localStorage.setItem("username",data.username);
          navigate('/');
        }else{
            setError(data.message);
        }
      };
  return (
    <div className="login-container">
    <div className="login-box">
      <h2>Welcome Back!</h2>
      <form onSubmit={handleLogin}>
        <input
          type="email"
          placeholder="Email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
          required
        />
        <input
          type="password"
          placeholder="Password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
          required
        />
        <button type="submit">Login</button>
      </form>
      <Link to='/signup'>Already Have An Account?</Link>
      {error && <div className="error-message">{error}</div>}
    </div>
  </div>
   
  )
}

export default LoginForm