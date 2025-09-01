import { ref } from 'vue';
import axios from 'axios';
import { getApiUrl } from '@/config/api';

export function useAdminAuth() {
  const isAuthenticated = ref(false);
  const adminUser = ref(null);

  const checkAuth = () => {
    const token = localStorage.getItem('admin_token');
    const userStr = localStorage.getItem('adminUser');
    
    if (token && userStr) {
      isAuthenticated.value = true;
      adminUser.value = JSON.parse(userStr);
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
      return true;
    }
    
    isAuthenticated.value = false;
    adminUser.value = null;
    return false;
  };

  const login = async (email, password) => {
    try {
      const response = await axios.post(getApiUrl('/api/admin/login'), {
        email,
        password
      });

      localStorage.setItem('admin_token', response.data.token);
      localStorage.setItem('adminUser', JSON.stringify(response.data.user));
      
      axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
      
      isAuthenticated.value = true;
      adminUser.value = response.data.user;
      
      return { success: true, data: response.data };
    } catch (error) {
      return { 
        success: false, 
        error: error.response?.data?.message || 'ログインに失敗しました' 
      };
    }
  };

  const logout = () => {
    localStorage.removeItem('admin_token');
    localStorage.removeItem('adminUser');
    delete axios.defaults.headers.common['Authorization'];
    
    isAuthenticated.value = false;
    adminUser.value = null;
  };

  return {
    isAuthenticated,
    adminUser,
    checkAuth,
    login,
    logout
  };
}